<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text("caption")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->enum("type", ["post", "page", "group"]);
            $table->enum("status", ["active", "draft", "banned"])->default("active");

            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
