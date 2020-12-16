<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping_unit extends Model
{
    protected $table="shipping_units";
    protected $primaryKey="id_shipping_unit"; 
    
    protected $guarded=[];
}
