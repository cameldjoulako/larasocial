<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("ticket_id");
            $table->text("response");
            $table->unsignedBigInteger("response_by");
            $table->boolean("is_read")->default(0);
            $table->timestamps();

            $table->foreign("ticket_id")->references("id")->on("tickets")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->foreign("response_by")->references("id")->on("users")
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
        Schema::dropIfExists('ticket_responses');
    }
}
