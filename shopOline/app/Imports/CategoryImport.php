<?php

namespace App\Imports;

use App\Models\Product_type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class CategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product_type([
            'name_product_type'=>$row[0],
            'status'=>$row[1],
        ]);
    }
}
