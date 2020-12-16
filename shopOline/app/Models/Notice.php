<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table="notices";
    protected $primaryKey="id_notice"; 
    protected $guarded=[];
}
