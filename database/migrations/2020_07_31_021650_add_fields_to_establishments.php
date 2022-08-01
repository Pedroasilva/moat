<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToEstablishments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->string('city', 50)->nullable();
            $table->string('address_line_1', 60)->nullable();
            $table->string('address_line_2', 60)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->default('Brasil');
            $table->string('postalCode', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            //
        });
    }
}
