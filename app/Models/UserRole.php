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

    /**
     * Funcion para Buscar los permisos del Rol
     */
    public function permissions(){
        return $this->hasMany(RolePermission::class,'role_id','role_id')->with('permission');
    }
}