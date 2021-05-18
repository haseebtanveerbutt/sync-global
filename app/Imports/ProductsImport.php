<?php

namespace App\Imports;

use App\Contact;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contact([
            'first_name'     => $row['first_name'],
            'last_name'    => $row['last_name'],
            'email' => $row['email'],
        ]);
    }
}
