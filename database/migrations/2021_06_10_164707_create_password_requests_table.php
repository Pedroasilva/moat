<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->nullable();
            $table->foreign('user')->references('user_id')->on('users');
            $table->string('authenticity_token', 300)->nullable();
            $table->dateTime('expire')->nullable();
            $table->boolean('done')->default(0);
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
        Schema::dropIfExists('password_requests');
    }
}
