<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSykesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create the tables
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('__pk');
            $table->unsignedInteger('_fk_property')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->increments('__pk');
            $table->string('location_name')->nullable();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->increments('__pk');
            $table->unsignedInteger('_fk_location')->nullable();
            $table->string('property_name')->nullable();
            $table->unsignedTinyInteger('near_beach')->nullable();
            $table->unsignedTinyInteger('accepts_pets')->nullable();
            $table->unsignedTinyInteger('sleeps')->nullable();
            $table->unsignedTinyInteger('beds')->nullable();
        });
        
        //Insert data into tables.
        DB::table('bookings')->insert([ '__pk' => '1', '_fk_property' => '1', 'start_date' => '2020-08-26', 'end_date' => '2020-08-26' ]);
        DB::table('bookings')->insert([ '__pk' => '2', '_fk_property' => '1', 'start_date' => '2020-12-06','end_date' => '2020-12-06' ]);
            
        DB::table('locations')->insert([ '__pk' => 1, 'location_name' => 'Cornwall']);
        DB::table('locations')->insert([ '__pk' => 2, 'location_name' => 'Lake District']);
        DB::table('locations')->insert([ '__pk' => 3, 'location_name' => 'Yorkshire']);
        DB::table('locations')->insert([ '__pk' => 4, 'location_name' => 'Wales']);
        DB::table('locations')->insert([ '__pk' => 5, 'location_name' => 'Scotland']);
            
        DB::table('properties')->insert(['__pk' => 1, '_fk_location' => 1, 'property_name' => 'Sea View', 'near_beach' => 1, 'accepts_pets' => 1, 'sleeps' => 4, 'beds' => 2]);
        DB::table('properties')->insert(['__pk' => 2, '_fk_location' => 3, 'property_name' => 'Cosey', 'near_beach' => 0, 'accepts_pets' => 0, 'sleeps' => 6, 'beds' => 4]);
        DB::table('properties')->insert(['__pk' => 3, '_fk_location' => 5, 'property_name' => 'The Retreat', 'near_beach' => 1, 'accepts_pets' => 0, 'sleeps' => 2, 'beds' => 1]);
        DB::table('properties')->insert(['__pk' => 4, '_fk_location' => 5, 'property_name' => 'Coach House', 'near_beach' => 0, 'accepts_pets' => 1, 'sleeps' => 5, 'beds' => 3]);
        DB::table('properties')->insert(['__pk' => 5, '_fk_location' => 4, 'property_name' => 'Beach Cottage', 'near_beach' => 1, 'accepts_pets' => 1, 'sleeps' => 8, 'beds' => 6]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');

        Schema::dropIfExists('locations');

        Schema::dropIfExists('bookings');
    }
}
