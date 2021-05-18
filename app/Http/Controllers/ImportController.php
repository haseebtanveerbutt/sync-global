<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Imports\CsvImport;
use App\Imports\ProductsImport;
use App\Product;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function getImport()
    {
        return view('import');
    }

    public function parseImport(Request $request)
    {
        dd($request->all());

        $path = $request->file('csv_file')->getRealPath();
        if ($request->has('header')) {
//            $data = Excel::import(new CsvImport, request()->file('csv_file'));
            $data = fopen($path,'r');
            $data = fgetcsv($data);
//            dd($data);
        } else {
            $data = array_map('str_getcsv', file($path));
//            dd($data);
        }

        if (true) {
//            if ($request->has('header')) {
//                $csv_header_fields = [];
//                foreach ($data[0] as $key => $value) {
//                    $csv_header_fields[] = $key;
//                }
//            }
            $csv_data = array_slice($data, 0, 2);
            dd($csv_data);

            $csv_data_file = Product::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

    }

    public function processImport(Request $request)
    {
        $data = Product::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                } else {
                    $contact->$field = $row[$request->fields[$index]];
                }
            }
            $contact->save();
        }

        return view('import_success');
    }
}
