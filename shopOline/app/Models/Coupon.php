<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table="coupons";
    protected $primaryKey="coupon_id"; 
    
    protected $guarded=[];
}
