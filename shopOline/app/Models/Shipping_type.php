<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping_type extends Model
{
    protected $table="shipping_types";
    protected $primaryKey="id_shipping_type"; 
    
    protected $guarded=[];
}
