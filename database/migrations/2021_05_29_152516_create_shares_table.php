<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("shared_post_id");
            $table->unsignedBigInteger("post_id");
            $table->unsignedBigInteger("user_id");
            $table->enum("type", ["timeline", "page", "group"]);
            $table->timestamps();

            $table->foreign("shared_post_id")->references("id")->on("posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->foreign("post_id")->references("id")->on("posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");
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
        Schema::dropIfExists('shares');
    }
}
