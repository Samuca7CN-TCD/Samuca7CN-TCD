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
            $table->unsignedBigInteger('budget_id');
            $table->boolean('entry');
            $table->boolean('paid');
            $table->double('amount');
            $table->date('payment_deadline');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('ceremony_id')->references('id')->on('ceremonies');
            $table->foreign('budget_id')->references('id')->on('budgets');
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
