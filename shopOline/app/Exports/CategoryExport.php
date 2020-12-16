<?php

namespace App\Exports;

use App\Models\Product_type;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product_type::select('id_product_type','name_product_type')->get();
    }

    public function headings() :array {
    	return ["Mã danh mục", "Tên danh mục"];
    }
}
