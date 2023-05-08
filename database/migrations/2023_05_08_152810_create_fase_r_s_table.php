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
        Schema::create('fase_r_s', function (Blueprint $table) {
            $table->id();
            $table->integer('compressores_id');
            $table->float('tensao');
            $table->float('corrente');
            $table->float('consumo');
            $table->float('potencia');
            $table->float('fator_potencia');
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
        Schema::dropIfExists('fase_r_s');
    }
};
