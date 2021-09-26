<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Permission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Migration Permission
        Schema::create('permission', function(Blueprint $table){
            $table->id();
            $table->string('name',50)->unique();
            $table->string('description',250);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop Table Permission
        Schema::dropIfExists('permission');
    }
}
