<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','role_id'];
    protected $table = 'user_role';
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function roles(){
        return $this->hasOne(Role::class,'id','role_id');
    }
}