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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('accounting_status_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('total_amount');
            $table->double('remaining_amount');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('accounting_status_id')->references('id')->on('accounting_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debts');
    }
};
