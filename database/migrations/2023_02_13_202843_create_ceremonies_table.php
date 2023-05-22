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
        Schema::create('ceremonies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->double('total_negotiated_amount');
            $table->double('paid_amount');
            $table->tinyInteger('status');
            $table->text('observations')->nullable();

            $table->json('installments')->nullable();
            $table->double('total_installments')->nullable();
            $table->tinyInteger('installment_option');

            $table->json('additions')->nullable();
            $table->double('total_additions')->nullable();

            $table->json('expenses')->nullable();
            $table->double('total_expenses')->nullable();

            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('ceremonies');
    }
};
