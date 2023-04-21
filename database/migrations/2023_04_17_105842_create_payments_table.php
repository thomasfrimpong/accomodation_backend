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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('guest_id');
            $table->integer('amount');
            $table->boolean('is_invalid');
            $table->unsignedBigInteger('added_by');

            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('room_id');


            $table->foreign('service_id')
                ->references('id')->on('services')->onDelete('cascade');

            $table->foreign('added_by')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('room_id')
                ->references('id')->on('rooms')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
};
