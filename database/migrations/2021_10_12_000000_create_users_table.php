<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',120);
            $table->string('password',120);
            $table->string('email',50)->unique();
            $table->integer('age');
            $table->date('date_of_birth');
            $table->string('sex',10);
            $table->string('dni',30)->unique();
            $table->string('address',250);
            $table->integer('id_country');
            $table->string('phone',50);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_country')->references('id')->on('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
