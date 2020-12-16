<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table="bills";
    protected $primaryKey="id_bill"; 
    protected $guarded=[];
    
}
