<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO: files, comments
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('executor_id');
            $table->foreignId('client_id');
            $table->text('short_description');
            $table->text('full_description')->nullable();
            $table->string('type')->default('consultation');
            $table->string('status')->default('new');
            $table->string('priority')->nullable();
            $table->text('tech_comment')->nullable();
            $table->text('client_comment')->nullable();
            $table->integer('client_total_time')->nullable();
            $table->timestamps();
            $table->timestamp('deadline_at', 0)->nullable();
            $table->timestamp('finished_at', 0)->nullable();
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
}
