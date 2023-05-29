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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('decoration_id');
            $table->unsignedBigInteger('buffet_entry_id');
            $table->unsignedBigInteger('buffet_id');
            $table->boolean('beer');
            $table->boolean('bar');
            $table->boolean('dj');
            $table->boolean('advisory');
            $table->boolean('additional_meat');
            $table->boolean('ravioli');
            $table->boolean('additional_drinks');
            $table->boolean('other_beers');
            $table->integer('guests_quantity');
            $table->dateTimeTz('event_date');
            $table->text('budget_comment')->nullable();
            $table->string('budget_token')->nullable();
            $table->float('budget_total_value');
            $table->string('budget_link')->nullable();
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('decoration_id')->references('id')->on('decorations');
            $table->foreign('buffet_entry_id')->references('id')->on('buffets');
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
        Schema::dropIfExists('budgets');
    }
};
