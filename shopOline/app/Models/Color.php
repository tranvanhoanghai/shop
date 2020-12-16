<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table="colors";
    protected $primaryKey="id_color"; 
    protected $guarded=[];

    public function sizes(){
        return $this->belongsToMany(Size::class, 'id_size') ;
    }
}
