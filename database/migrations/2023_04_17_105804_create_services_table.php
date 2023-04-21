<?php

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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->string('start_of_residence');
            $table->string('end_of_residence');
            $table->boolean('duration_extended');
            $table->boolean('duration_reduced');
            $table->boolean('is_reservation');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('guest_id');

            $table->foreign('room_id')
                ->references('id')->on('rooms')->onDelete('cascade');


            $table->foreign('added_by')
                ->references('id')->on('users')->onDelete('cascade');


            $table->foreign('guest_id')
                ->references('id')->on('guests')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
};
