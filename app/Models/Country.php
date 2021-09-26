<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['id','sort_name','name'];
    protected $table = 'country';
    protected $hidden = ['created_at','updated_at','deleted_at'];
}