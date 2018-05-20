<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeColumnsLimitToLocationLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location__locations', function (Blueprint $table){
            $table->string('phone1', 30)->nullable()->change();
            $table->string('phone2', 30)->nullable()->change();
            $table->string('mobile', 30)->nullable()->change();
            $table->string('fax', 30)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->string('phone1', 20)->nullable()->change();
        $table->string('phone2', 20)->nullable()->change();
        $table->string('mobile', 20)->nullable()->change();
        $table->string('fax', 20)->nullable()->change();
    }
}
