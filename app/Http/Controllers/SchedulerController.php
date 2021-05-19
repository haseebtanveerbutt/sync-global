<?php

namespace App\Http\Controllers;

use App\Product;
use App\Scheduler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SchedulerController extends Controller
{

    public function scheduler_list(){
        $scheduler_data = Scheduler::where('shopify_shop_id',Auth::user()->id)->where('shopify_fields','!=',null)->orderBy('created_at', 'desc')->get();
        return view('adminpanel/scheduler_list',compact('scheduler_data'));
    }

    public function scheduler_index(){
        return view('adminpanel/scheduler_index');
    }

    public function scheduler_save(Request $request)
    {
//        dd($request->all());
        $url = $request->file_path;

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

        $schedule = new Scheduler();
        $schedule->shopify_shop_id = $request->user_id;
        $schedule->name = $request->name;
        $schedule->file_path = $request->file_path;
        $schedule->frequency = $request->frequency;
        if(isset($request->active) && $request->active != null){
            $schedule->active = $request->active;
        }
        $schedule->save();

        $schedule_id = $schedule->id;
        $user_id = $schedule->shopify_shop_id;

        return view('adminpanel/scheduler_mapping_via_url', compact('csv_headers', 'file_path','schedule_id','user_id'));

    }

    public function scheduler_url_mapped_field(Request $request){
//        dd($request->all());
        $scheduler_check = Scheduler::where(['shopify_shop_id'=>$request->user_id, 'id'=>$request->schedule_id])->first();
        if(isset($scheduler_check)){
            $scheduler_check->shopify_fields = json_encode($request->shopify_fields);
            $scheduler_check->save();
        }

        return redirect('schedulers-list')->with('success', 'Scheduler set Successfuly!');
    }

    public function edited_scheduler_url_mapped_field(Request $request,$id){
//        dd($request->all());
        $scheduler_check = Scheduler::where(['shopify_shop_id'=>$request->user_id, 'id'=>$id])->first();
        if(isset($scheduler_check)){
            $scheduler_check->shopify_fields = json_encode($request->shopify_fields);
            $scheduler_check->save();
        }

        return redirect('schedulers-list')->with('success', 'Scheduler Updated Successfuly!');
    }

    public function scheduler_edit($id){
        $scheduler_data = Scheduler::where('id',$id)->first();
        return view('adminpanel/scheduler_edit_index', compact('scheduler_data'));
    }

    public function edit_scheduler_save(Request $request, $id){

        $url = $request->file_path;

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

        $scheduler_save = Scheduler::where('id',$id)->first();

        if($scheduler_save == null){
            $scheduler_save = new Scheduler();
        }
        $scheduler_save->shopify_shop_id = $request->user_id;
        $scheduler_save->name = $request->name;
        $scheduler_save->file_path = $request->file_path;
        $scheduler_save->frequency = $request->frequency;
        if(isset($request->active) && $request->active != null){
            $scheduler_save->active = $request->active;
        }
        $scheduler_save->save();

        $schedule_id = $scheduler_save->id;
        $user_id = $scheduler_save->shopify_shop_id;
        $shopify_fields = json_decode($scheduler_save->shopify_fields);

        return view('adminpanel/edited_scheduler_mapping_via_url', compact('csv_headers','shopify_fields', 'file_path','schedule_id','user_id'));

    }

    public function scheduler_delete($id){
        $scheduler_delete = Scheduler::where('id',$id)->first();
        if(isset($scheduler_delete)){
            $scheduler_delete->delete();
        }

        return redirect()->back()->with('success', 'Scheduler Delete Successfuly!');
    }
}
