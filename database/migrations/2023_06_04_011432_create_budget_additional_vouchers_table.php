<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget_additional_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_additional_id');
            $table->string('name');
            $table->double('value');
            $table->string('file')->unique();
            $table->dateTime('payment_date');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('budget_additional_id')->references('id')->on('budget_additionals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_additional_vouchers');
    }
};
