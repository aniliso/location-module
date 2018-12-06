<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranslationColumnsToLocationLocationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location__location_translations', function (Blueprint $table) {
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email', 100)->nullable();
        });

        $locations = app(\Modules\Location\Entities\Location::class)->get();

        foreach ($locations as $location) {
            foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                $location->translate($locale)->phone1 = $location->getAttributeValue('phone1');
                $location->translate($locale)->phone2 = $location->getAttributeValue('phone2');
                $location->translate($locale)->mobile = $location->getAttributeValue('mobile');
                $location->translate($locale)->fax    = $location->getAttributeValue('fax');
                $location->translate($locale)->email  = $location->getAttributeValue('email');
            }
            $location->save();
        }

        Schema::table('location__locations', function (Blueprint $table) {
            $table->dropColumn('phone1');
            $table->dropColumn('phone2');
            $table->dropColumn('mobile');
            $table->dropColumn('fax');
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location__locations', function (Blueprint $table) {
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email', 100)->nullable();
        });

        $locations = app(\Modules\Location\Entities\Location::class)->get();

        foreach ($locations as $location) {
            $attributes = $location->getAttributes();
            $attributes['phone1'] = $location->phone1;
            $attributes['phone2'] = $location->phone2;
            $attributes['mobile'] = $location->mobile;
            $attributes['fax'] = $location->fax;
            $attributes['email'] = $location->email;
            $location->setRawAttributes($attributes);
            $location->save();
        }

        Schema::table('location__location_translations', function (Blueprint $table) {
            $table->dropColumn('phone1');
            $table->dropColumn('phone2');
            $table->dropColumn('mobile');
            $table->dropColumn('fax');
            $table->dropColumn('email');
        });
    }
}
