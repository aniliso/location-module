<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationLocationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location__location_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('name', 200);
            $table->string('slug', 200);

            $table->integer('location_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['location_id', 'locale']);
            $table->foreign('location_id')->references('id')->on('location__locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location__location_translations', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        Schema::dropIfExists('location__location_translations');
    }
}
