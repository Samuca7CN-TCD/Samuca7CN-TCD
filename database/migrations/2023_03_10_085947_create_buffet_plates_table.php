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
        Schema::create('buffet_plates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->string('name');
            $table->string('description')->nullable();
            $table->double('cost');
            $table->integer('qtd_per_ten_people');
            $table->string('measure_unity');
            $table->unsignedBigInteger('buffet_id')->nullable();
            // $table->json('ingredients')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('buffet_id')->references('id')->on('buffets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buffet_plates');
    }
};
