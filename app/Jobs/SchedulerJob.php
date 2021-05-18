<?php

namespace App\Jobs;

use App\ErrorLog;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SchedulerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $scheduler;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scheduler)
    {
        $this->scheduler=$scheduler;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $scheduler = $this->scheduler;

        try {

           $scheduler_fields = json_decode($scheduler->shopify_fields);
            $url = $scheduler->file_path;

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

            $file_keys = array_keys($csv_items[0]);
//            dd($request->shopify_fields);
            $csv_pair_keys = array_combine($scheduler_fields, $file_keys);
    //        dd($csv_pair_keys);
            foreach ($csv_items as $index => $row) {
                $data = array_values($row);
    //            dd($data);
                $status = 'update';
                $product = Product::where('shopify_shop_id', $scheduler->shopify_shop_id)->WhereIn('variant_sku', $data)->first();
                if($product == null){
                    $product = new Product();
                    $status = 'create';
                }
                foreach ($csv_pair_keys as $key => $value) {
//                    dd($csv_pair_keys);
                    if ($key == 'ignore') {
                        continue;
                    } else {
                        $product->$key = $row[$value];
                    }
                }
                $product->shopify_shop_id = $scheduler->shopify_shop_id;
                $product->status = $status;
                $product->save();
//                $new = new ErrorLog();
//                $new->message = json_encode($product);
//                $new->save();

            }
//
//            $product_create_pushs = Product::where(['shopify_shop_id'=>$scheduler->shopify_shop_id,'shopify_product_status'=>null])->get();
//            $shop = Auth::user();
//            if(count($product_create_pushs)){
//                foreach ($product_create_pushs as $product_push){
//                    $this->product_create($product_push,$shop);
//                }
//            }
//            $product_update_pushs = Product::where(['shopify_shop_id'=>$scheduler->shopify_shop_id, 'status'=>'update','shopify_product_status'=>'pushed'])->get();
//
//            if(count($product_update_pushs)){
//                foreach ($product_update_pushs as $product_push){
//                    $this->product_update($product_push,$shop);
//                }
//            }
        }catch (\Exception $exception)
        {
            $new = new ErrorLog();
            $new->message = $exception->getMessage();
            $new->save();
        }
    }
}
