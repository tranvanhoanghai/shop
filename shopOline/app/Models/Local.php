<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
     protected $table="locals";
    protected $primaryKey="id_local"; 
    
    protected $guarded=[];
}
