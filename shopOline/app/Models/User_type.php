<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    protected $table="user_types";
    protected $primaryKey="id_user_type"; 
    
    protected $guarded=[]; #không có trường nào cần bảo vệ, tương tác all
}
