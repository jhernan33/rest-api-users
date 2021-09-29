<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'full_name',
        'password',
        'email',
        'age',
        'date_of_birth',
        'sex',
        'dni',
        'address',
        'id_country',
        'phone',
    ];

    protected $table =  'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Search Role and Permissions
     */
    public function role(){
        $obj = $this->hasMany(UserRole::class,'user_id','id')
        ->join('role', 'role.id', '=', 'role_id')->with('permissions');
        return $obj;
    }

    /**
     * Funcion para buscar el tipo de Rol del Usuario
     */
    public function TipoRole($id){
        return UserRole::where('user_id','=',$id)->select('role_id')->get()->toArray()[0]["role_id"];
    }
}
