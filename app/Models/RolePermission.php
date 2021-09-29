<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $fillable = ['role_id','permission_id'];
    protected $table = 'role_permission';
    protected $hidden = ['created_at','updated_at','deleted_at'];

    /**
     * Funcion par abuscar los Permisos
     */
    public function permission(){
        return $this->hasOne(Permission::class,'id','permission_id');
    }
}