<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('competitions');
        Schema::create('competions', function (Blueprint $table) {
            $table->id();
            $table->string('name_competition');
            $table->date('date_competition');
            $table->string('address_competition');
            $table->string('postal_code_competition');
            $table->string('city_competition');
            $table->double('lat_competition',8,6);
            $table->double('lon_competition',8,6);
            $table->string('organizational_details')->nullable();
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
        Schema::dropIfExists('competion');
    }
};
