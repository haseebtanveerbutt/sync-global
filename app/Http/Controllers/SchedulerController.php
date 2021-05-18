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
        $scheduler_data = Scheduler::where('shopify_shop_id',Auth::user()->id)->orderBy('created_at', 'desc')->get();
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
}
