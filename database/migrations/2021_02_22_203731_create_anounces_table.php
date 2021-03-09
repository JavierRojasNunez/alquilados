<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnouncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anounces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('type_rent');
            $table->float('price', 8, 2);
            $table->string('min_time_ocupation')->nullable(true);
            $table->string('payment_period')->nullable(true);
            $table->integer('meter2')->nullable(true);
            $table->integer('num_roomms_for_rent')->nullable(true);
            $table->integer('num_rooms')->nullable(true);
            $table->integer('num_baths')->nullable(true);
            $table->float('deposit', 8, 2)->nullable(true);
            $table->date('available_date')->nullable(true);
            $table->string('titulo', 255)->nullable(true);
            $table->mediumText('descripcion')->nullable(true);
            $table->integer('num_people_in')->nullable(true);
            $table->string('people_in_job')->nullable(true);
            $table->string('people_in_sex')->nullable(true);
            $table->boolean('people_in_tabaco')->nullable(true);
            $table->boolean('people_in_pet')->nullable(true);
            $table->string('lookfor_who_job')->nullable(true);
            $table->string('lookfor_who_sex')->nullable(true);
            $table->boolean('lookfor_who_tabaco')->nullable(true);
            $table->boolean('lookfor_who_pet')->nullable(true);
            $table->string('cauntry_rent')->nullable(true);
            $table->string('province_rent')->nullable(true);
            $table->string('city_rent')->nullable(true);
            $table->string('street_rent')->nullable(true);
            $table->string('adress_rent')->nullable(true);
            $table->string('num_street_rent')->nullable(true);
            $table->string('flat_street_rent')->nullable(true);
            $table->string('cp_rent')->nullable(true);
            $table->integer('phone', 10)->nullable(true);
            $table->boolean('funiture')->nullable(true);
            $table->boolean('ascensor')->nullable(true);
            $table->boolean('calefaction')->nullable(true);
            $table->boolean('balcon')->nullable(true);
            $table->boolean('terraza')->nullable(true);
            $table->boolean('gas')->nullable(true);
            $table->boolean('swiming')->nullable(true);
            $table->boolean('internet')->nullable(true);
            $table->boolean('washing_machine')->nullable(true);
            $table->boolean('fridge')->nullable(true);
            $table->boolean('kitchen')->nullable(true);
            $table->boolean('near_bus')->nullable(true);
            $table->boolean('near_underground')->nullable(true);
            $table->boolean('near_tren')->nullable(true);
            $table->boolean('near_school')->nullable(true);
            $table->boolean('near_airport')->nullable(true);
            $table->mediumText('observations')->nullable(true);
            $table->string('foto1')->nullable(true);
            $table->string('foto2')->nullable(true);
            $table->string('foto3')->nullable(true);
            $table->string('foto4')->nullable(true);
            $table->string('foto5')->nullable(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anounces');
    }
}

