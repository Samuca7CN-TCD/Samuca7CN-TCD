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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ceremony_id');
            $table->string('name');
            $table->tinyInteger('type');
            $table->double('paid_amount');
            $table->boolean('paid');
            $table->double('total_amount');
            $table->dateTime('deadline');
            $table->boolean('entry');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('ceremony_id')->references('id')->on('ceremonies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installments');
    }
};
