<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->enum("gender", ["male", "female"]);
            $table->string('password');

            $table->text("profile_image")->nullable();
            $table->text("cover_photo")->nullable();
            $table->text("dob")->nullable();
            $table->text("about_me")->nullable();

            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("country_id");

            $table->enum("role", ["admin", "user"])->default("user");
            $table->timestamps();

            $table->foreign("city_id")->references("id")->on("cities")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->foreign("country_id")->references("id")->on("countries")
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
        Schema::dropIfExists('users');
    }
}
