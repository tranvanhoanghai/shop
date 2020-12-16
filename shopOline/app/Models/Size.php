<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table="sizes";
    protected $primaryKey="id_size"; 
    
    protected $guarded=[];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'id_color') ;
    }
}
