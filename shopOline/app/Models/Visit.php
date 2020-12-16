<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table="visits";
    protected $primaryKey="id"; 
    protected $guarded = [];
    protected $casts = ['list' => 'array'];
    protected $dates = ['expired_at'];

}
