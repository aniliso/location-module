<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('address');

            $table->string('long', 20)->nullable();
            $table->string('lat', 20)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('fax', 20)->nullable();;
            $table->string('email', 100)->nullable();;
            $table->string('postcode', 20)->nullable();;

            $table->smallInteger('ordering')->default(1);
            $table->tinyInteger('status')->default(1);

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('localization__countries')->onDelete('SET NULL');

            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('localization__cities')->onDelete('SET NULL');

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
        Schema::dropIfExists('location__locations');
    }
}
