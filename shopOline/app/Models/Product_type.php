<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{
    protected $table="product_types";
    protected $primaryKey="id_product_type"; 
    protected $guarded=[];
}
