<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping_price extends Model
{
    protected $table="shipping_prices";
    protected $primaryKey="id_shipping_price"; 
    
    protected $guarded=[];
}
