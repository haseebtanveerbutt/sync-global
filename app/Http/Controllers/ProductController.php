<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function sync_api_products(){
        $sync_api_products = Http::withBasicAuth('tlhtestuser', 'Tlhtestuser1')
            ->get('https://api.stuller.com/v2/products')->object();
        dd($sync_api_products);


    }
}
