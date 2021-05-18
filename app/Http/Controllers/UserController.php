<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function user_dashboard()
    {
        return view('adminpanel/user_dashboard');
    }

    public function import_data_info_page(Request $request)
    {
//        dd($request->all());
        switch ($request->choose_file) {
            case 'upload-file':
                return view('adminpanel/upload_file');
                break;
            case 'import-via-ftp':
                return view('adminpanel/import_via_ftp');
                break;
            case 'import-via-url':
                return view('adminpanel/import_via_url');
                break;
            case 'import-via-api':
                return view('adminpanel/import_via_api');
                break;
        }
    }

    public function csv_upload(Request $request)
    {
//        dd($request->csv_file);
        $image = $request->file('csv_file');
        $destinationPath = 'import-csv/';
        $filename = now()->format('YmdHi') . str_replace([' ', '(', ')'], '-', $image->getClientOriginalName());
        $file_path = $image->move($destinationPath, $filename);

        $csv_headers = null;
        $csv_items = [];
        if (($handle = fopen($file_path, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!$csv_headers)
                    $csv_headers = $row;
                else
                    $csv_items[] = array_combine($csv_headers, $row);
            }
            fclose($handle);
        }

        return view('adminpanel/csv_file_mapping', compact('csv_headers', 'csv_items', 'file_path'));
    }

    public function csv_mapped_field(Request $request)
    {
        $csv_headers = null;
        $csv_items = [];
        if (($handle = fopen($request->file_path, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!$csv_headers)
                    $csv_headers = $row;
                else
                    $csv_items[] = array_combine($csv_headers, $row);
            }
            fclose($handle);
        }

        $file_keys = array_keys($csv_items[0]);
        $csv_pair_keys = array_combine($request->shopify_fields, $file_keys);

        foreach ($csv_items as $index => $row) {
            $data = array_values($row);
            $status = 'update';
            $product = Product::where('shopify_shop_id', Auth::user()->id)->WhereIn('variant_sku', $data)->first();
            if($product == null){
               $product = new Product();
               $status = 'create';
            }
            foreach ($csv_pair_keys as $key => $value) {
                if ($key == 'ignore') {
                    continue;
                } else {
                    $product->$key = $row[$value];
                }
            }
            $product->shopify_shop_id = Auth::user()->id;
            $product->status = $status;
            if($product->save()){
//                dd($product);
            }else{
                $product->status = 'create';
                $product->save();
                return redirect('/')->with('error', 'Product not saved to database!');
            }

        }

        $product_create_pushs = Product::where(['shopify_shop_id'=>Auth::user()->id,'shopify_product_status'=>null])->get();
         $shop = Auth::user();
        if(count($product_create_pushs)){
            foreach ($product_create_pushs as $product_push){
                $this->product_create($product_push,$shop);
            }
        }
        $product_update_pushs = Product::where(['shopify_shop_id'=>Auth::user()->id, 'status'=>'update','shopify_product_status'=>'pushed'])->get();

        if(count($product_update_pushs)){
            foreach ($product_update_pushs as $product_push){
                $this->product_update($product_push,$shop);
            }
        }
        return redirect('/')->with('success', 'Products Import Successfuly!');
    }

    public function url_mapped_field(Request $request)
    {
        $csv_headers = null;
        $csv_items = [];

        if (($handle = fopen(Storage::path($request->file_path), 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!$csv_headers)
                    $csv_headers = $row;
                else
                    $csv_items[] = array_combine($csv_headers, $row);
            }
            fclose($handle);
        }

        $file_keys = array_keys($csv_items[0]);
        $csv_pair_keys = array_combine($request->shopify_fields, $file_keys);

        foreach ($csv_items as $index => $row) {
            $data = array_values($row);
            $status = 'update';
            $product = Product::where('shopify_shop_id', Auth::user()->id)->WhereIn('variant_sku', $data)->first();
            if($product == null){
                $product = new Product();
                $status = 'create';
            }
            foreach ($csv_pair_keys as $key => $value) {
                if ($key == 'ignore') {
                    continue;
                } else {
                    $product->$key = $row[$value];
                }
            }
            $product->shopify_shop_id = Auth::user()->id;
            $product->status = $status;
            if($product->save()){
//                dd($product);
            }else{
                return redirect('/')->with('error', 'Product not saved to database!');
            }

        }
        $product_create_pushs = Product::where(['shopify_shop_id'=>Auth::user()->id,'shopify_product_status'=>null])->get();
        $shop = Auth::user();
        if(count($product_create_pushs)){
            foreach ($product_create_pushs as $product_push){
                $this->product_create($product_push,$shop);
            }
        }
        $product_update_pushs = Product::where(['shopify_shop_id'=>Auth::user()->id, 'status'=>'update','shopify_product_status'=>'pushed'])->get();

        if(count($product_update_pushs)){
            foreach ($product_update_pushs as $product_push){
                $this->product_update($product_push,$shop);
            }
        }
        return redirect('/')->with('success', 'Products Import Successfuly!');

    }

    public function product_create($product, $shop)
    {

            $variants=[];

            if($product->variant_fulfillment_service == null){
               $fulfillment_service = 'manual';
            }else{
                $fulfillment_service= $product->variant_fulfillment_service;
            }
            if($product->variant_inventory_policy == null){
               $inventory_policy = 'continue';
            }else{
                $inventory_policy= $product->variant_fulfillment_service;
            }
            $product = json_decode(json_encode($product),false);
            array_push($variants, [
                "option1" => $product->variant_option1_value,
                "option2"=> $product->variant_option2_value,
                "option3"=> $product->variant_option3_value,
                "price"=> $product->variant_price,
                "sku"=> $product->variant_sku,
                "inventory_quantity" => $product->variant_inventory_quantity,
                "old_inventory_quantity" => $product->variant_inventory_quantity,
                "barcode" => $product->variant_barcode,
                "inventory_policy" => $inventory_policy,
                "fulfillment_service" => $fulfillment_service,
                "inventory_management" => 'shopify',
                "compare_at_price" => $product->variant_compare_at_price,
                "taxable" => $product->variant_taxable,
                "title" => $product->variant_title,
                "weight" => $product->variant_weight,
                "weight_unit" => $product->variant_weight_unit,
                "requires_shipping" => $product->variant_requires_shipping,
            ]);

        $tags= explode(',',$product->tags);

        foreach ($tags as $tag){
            if($tag == ''){
                $tags = null;
            }
        }

        try {

            $productJson = [
                "title" => $product->title,
                "body_html" => $product->description,
                "product_type" => $product->product_type,
                "published" => 'true',
                "published_scope" => 'global',
                "vendor" => $product->vendor,
                'handle' => $product->handle,
                 "status" => 'active',
                "tags" => $tags,
                "variants" => $variants,
//                "options" => $values,

            ];
//            dd($productJson);
            $mainProduct = $shop->api()->rest('POST', '/admin/products.json', [
                'product' => $productJson
            ]);
//dd($mainProduct);
            if ($mainProduct['errors'] == false) {
                $product = Product::where(['shopify_shop_id'=>Auth::user()->id, 'shopify_product_status'=>null, 'variant_sku'=>$product->variant_sku])->first();
                $product->shopify_product_status = 'pushed';
                $product->shopify_product_id = $mainProduct['body']['product']->id;
                $product->save();

                if($product->image != null){
                    $i = [
                        'image' => [
                            'src'=>$product->image,
                            "position"=> 1,
                        ]
                    ];
                    $images_response = $shop->api()->rest('POST', '/admin/api/2019-10/products/'.$product->shopify_product_id.'/images.json', $i);
                    if(isset($images_response['body']['image']->id) && isset($images_response['body']['image']->product_id)) {
                        $product_image = Image::where(['shopify_shop_id' => Auth::user()->id, 'shopify_image_id' => $images_response['body']['image']->id])->first();
                        if ($product_image == null) {
                            $product_image = new Image();
                        }
                        $product_image->shopify_image_id = $images_response['body']['image']->id;
                        $product_image->shopify_product_id = $images_response['body']['image']->product_id;
                        $product_image->shopify_shop_id = Auth::user()->id;
                        $product_image->save();
                    }
                }
                $image_src= explode('|',$product->multiple_images);

                if(count($image_src) != null && isset($image_src)){

                    foreach ($image_src as $key =>$img){
                        if($img != null){
                            $i = [
                                'image' => [
                                    'src'=>$img,
                                    "position"=> 1,
                                ]
                            ];
                        }
                        $imagesResponse = $shop->api()->rest('POST', '/admin/api/2019-10/products/'.$product->shopify_product_id.'/images.json', $i);
                        if(isset($imagesResponse['body']['image']->id) && isset($imagesResponse['body']['image']->product_id)) {
                            $product_image = Image::where(['shopify_shop_id' => Auth::user()->id, 'shopify_image_id' => $imagesResponse['body']['image']->id])->first();
                            if ($product_image == null) {
                                $product_image = new Image();
                            }
                            $product_image->shopify_image_id = $imagesResponse['body']['image']->id;
                            $product_image->shopify_product_id = $imagesResponse['body']['image']->product_id;
                            $product_image->shopify_shop_id = Auth::user()->id;
                            $product_image->save();
                        }

                    }

                }

            }
        }catch (\Exception $exception){
//            return redirect('/')->with('error', $exception->getMessage());
        }
    }

    public function product_update($product, $shop){

        $variants=[];

        if($product->variant_fulfillment_service == null){
            $fulfillment_service = 'manual';
        }else{
            $fulfillment_service= $product->variant_fulfillment_service;
        }
        if($product->variant_inventory_policy == null){
            $inventory_policy = 'continue';
        }else{
            $inventory_policy= $product->variant_fulfillment_service;
        }
        $product = json_decode(json_encode($product),false);
        array_push($variants, [
            "option1" => $product->variant_option1_value,
            "option2"=> $product->variant_option2_value,
            "option3"=> $product->variant_option3_value,
            "price"=> $product->variant_price,
            "sku"=> $product->variant_sku,
            "inventory_quantity" => $product->variant_inventory_quantity,
            "old_inventory_quantity" => $product->variant_inventory_quantity,
            "inventory_policy" => $inventory_policy,
            "fulfillment_service" => $fulfillment_service,
            "inventory_management" => 'shopify',
            "compare_at_price" => $product->variant_compare_at_price,
            "taxable" => $product->variant_taxable,
            "title" => $product->variant_title,
            "weight" => $product->variant_weight,
            "weight_unit" => $product->variant_weight_unit,
            "requires_shipping" => $product->variant_requires_shipping,
        ]);

        $tags= explode(',',$product->tags);

        foreach ($tags as $tag){
            if($tag == ''){
                $tags = null;
            }
        }

        try {

            $productJson = [
                "title" => $product->title,
                "body_html" => $product->description,
                "product_type" => $product->product_type,
                "published" => 'true',
                "published_scope" => 'global',
                "vendor" => $product->vendor,
                'handle' => $product->handle,
                "status" => 'active',
                "tags" => $tags,
                "variants" => $variants,
//                "options" => $values,
            ];
//            dd($productJson);
//            dump($productJson);
//            dd($product->shopify_product_id);
            $mainProduct = $shop->api()->rest('PUT', '/admin/products/'.$product->shopify_product_id.'.json', [
                'product' => $productJson
            ]);
//            dd($mainProduct);
            if ($mainProduct['errors'] == false) {
                $product = Product::where(['shopify_shop_id'=>Auth::user()->id, 'shopify_product_status'=>'pushed', 'variant_sku'=>$product->variant_sku])->first();
                $product->shopify_product_status = 'pushed';
                $product->save();

                // first delete all previous images from store then after deleting, create all latest product image in store

                $product_image_delete = Image::where(['shopify_shop_id'=>Auth::user()->id, 'shopify_product_id'=>$product->shopify_product_id])->get();
                if(count($product_image_delete)){
//                    dd($product_image_delete);
                    foreach ($product_image_delete as $product_img_del){
                        if(isset($product_img_del->shopify_image_id)){
                            $shop->api()->rest('DELETE', '/admin/api/2019-10/products/'.$product_img_del->shopify_product_id.'/images/'.$product_img_del->shopify_image_id.'.json');
                            Image::where(['shopify_shop_id'=>Auth::user()->id, 'shopify_product_id'=>$product_img_del->shopify_product_id, 'shopify_image_id'=>$product_img_del->shopify_image_id])->delete();
                        }
                    }
                }

                if($product->image != null){
//                    dd($product->shopify_product_id,$product->image);
                    $i = [
                        'image' => [
                            'src'=>$product->image,
                            "position"=> 1,
                        ]
                    ];
                    $images_response =$shop->api()->rest('POST', '/admin/api/2019-10/products/'.$product->shopify_product_id.'/images.json', $i);
                    if(isset($images_response['body']['image']->id) && isset($images_response['body']['image']->product_id)){
                        $product_image =Image::where(['shopify_shop_id'=> Auth::user()->id,'shopify_image_id'=>$images_response['body']['image']->id])->first();
                        if($product_image == null)
                        {
                            $product_image = new Image();
                        }
                        $product_image->shopify_image_id = $images_response['body']['image']->id;
                        $product_image->shopify_product_id = $images_response['body']['image']->product_id;
                        $product_image->shopify_shop_id = Auth::user()->id;
                        $product_image->save();
                    }

                }

                $image_src= explode('|',$product->multiple_images);

                if(count($image_src) != null && isset($image_src)){

                    foreach ($image_src as $key =>$img){
                        if($img != null){
                            $i = [
                                'image' => [
                                    'src'=>$img,
                                    "position"=> 1,
                                ]
                            ];
                        }
                        $imagesResponse = $shop->api()->rest('POST', '/admin/api/2019-10/products/'.$product->shopify_product_id.'/images.json', $i);
                        if(isset($imagesResponse['body']['image']->id) && isset($imagesResponse['body']['image']->product_id)) {

                            $product_image = Image::where(['shopify_shop_id' => Auth::user()->id, 'shopify_image_id' => $imagesResponse['body']['image']->id])->first();
                            if ($product_image == null) {
                                $product_image = new Image();
                            }
                            $product_image->shopify_image_id = $imagesResponse['body']['image']->id;
                            $product_image->shopify_product_id = $imagesResponse['body']['image']->product_id;
                            $product_image->shopify_shop_id = Auth::user()->id;
                            $product_image->save();
                        }
                    }

                }
            }
        }catch (\Exception $exception){
            dd('error',$exception->getMessage());
        }
    }

    public function import_via_url(Request $request){

        $url = $request->import_via_url;

        $contents = file_get_contents($url);
        $file_path = now()->format('YmdHis') . str_replace([' ', '(', ')'], '-', '.csv');
        Storage::put($file_path, $contents);

        $csv_headers = null;
        $csv_items = [];
        if (($handle = fopen(Storage::path($file_path), 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!$csv_headers)
                    $csv_headers = $row;
                else
                    $csv_items[] = array_combine($csv_headers, $row);
            }
            fclose($handle);
        }

        return view('adminpanel/mapping_via_url', compact('csv_headers', 'file_path'));
    }



}

