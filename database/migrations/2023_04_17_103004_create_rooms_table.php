<?php

use Carbon\Carbon;
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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('price_of_room');
            $table->string('room_number');
            $table->integer('percentage_discount')->default(0);
            $table->boolean('state_of_occupancy')->default(false);
            $table->timestamp('date_of_availability')->useCurrent();
            $table->unsignedBigInteger('added_by');
            $table->boolean('is_reserved');


            $table->foreign('added_by')
                ->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
