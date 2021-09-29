<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['id','name'];
    protected $table = 'role';
    protected $hidden = ['created_at','updated_at','deleted_at'];

    /**
     * Buscar los permisos del Rol
     */
    public function permissions(){
        return $this->hasMany(RolePermission::class,'role_id','role_id');
    }
}
