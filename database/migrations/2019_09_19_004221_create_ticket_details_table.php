<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task');
            $table->boolean('state')->default(true);
            $table->string('concluding_remarks')->nullable();
            $table->unsignedBigInteger('ticket_id');


            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->dropForeign('ticket_details_ticket_id_foreign');
        });
        Schema::dropIfExists('ticket_details');
    }
}
