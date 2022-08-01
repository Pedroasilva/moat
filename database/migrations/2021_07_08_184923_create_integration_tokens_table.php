<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integration_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('authenticity_token', 300)->nullable();
            $table->integer('company')->unsigned()->nullable();
            $table->foreign('company')->references('establishment_id')->on('establishments');
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
        Schema::dropIfExists('integration_tokens');
    }
}
