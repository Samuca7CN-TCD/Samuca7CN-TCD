<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ceremony_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_status_id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->dateTimeTz('deadline')->nullable();
            $table->tinyInteger('priority')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('ceremony_id')->references('id')->on('ceremonies');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_status_id')->references('id')->on('task_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
