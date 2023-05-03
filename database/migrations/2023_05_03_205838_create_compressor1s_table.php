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
        Schema::create('compressor1s', function (Blueprint $table) {
            $table->id();

            $table->double('compressor');

            $table->double('tensao_r')->nullable();
            $table->double('tensao_s')->nullable();
            $table->double('tensao_t')->nullable();

            $table->double('corrente_r')->nullable();
            $table->double('corrente_s')->nullable();
            $table->double('corrente_t')->nullable();

            $table->double('consumo_r')->nullable();
            $table->double('consumo_s')->nullable();
            $table->double('consumo_t')->nullable();

            $table->double('potencia_r')->nullable();
            $table->double('potencia_s')->nullable();
            $table->double('potencia_t')->nullable();

            $table->double('fator_potencia_r')->nullable();
            $table->double('fator_potencia_s')->nullable();
            $table->double('fator_potencia_t')->nullable();

            $table->timestamp('data');

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
        Schema::dropIfExists('compressor1s');
    }
};
