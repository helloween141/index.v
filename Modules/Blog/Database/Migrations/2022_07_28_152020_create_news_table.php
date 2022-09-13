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
        Schema::create("news", function (Blueprint $table) {
            $table->increments("id");
            $table->string("title")->default("");
            $table->string("url")->default("");
            $table->timestamp("date");
            $table->text("short_text")->default("");
            $table->longText("full_text")->default("");
            $table->boolean("show")->default(1);
            $table->string("type")->default("");
            $table->integer("price")->default(0);
            $table->foreignId("file")->nullable()->constrained("files")->onDelete("cascade");
            $table->foreignId("image")->nullable()->constrained("files")->onDelete("cascade");
            $table->foreignId("author_id")->constrained("authors")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("news");
    }
};
