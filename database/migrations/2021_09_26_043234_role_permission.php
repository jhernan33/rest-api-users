<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // Migration Role Permission
       Schema::create('role_permission', function(Blueprint $table){
        $table->id();
        $table->integer('role_id');
        $table->integer('permission_id');
        $table->softDeletes();
        $table->timestamps();
        $table->foreign('role_id')->references('id')->on('role');
        $table->foreign('permission_id')->references('id')->on('permission');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         // Drop Table Roles
         Schema::dropIfExists('role_permission');
    }
}
