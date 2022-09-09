<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('');
            $table->string('url')->default('');
            $table->timestamp('date');
            $table->text('short_text');
            $table->longText('full_text');
            $table->boolean('show')->default(1);
            $table->string('type');
            $table->integer('price');
            $table->foreignId('file')->nullable()->constrained('files')->onDelete('cascade');
            $table->foreignId('image')->nullable()->constrained('files')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
