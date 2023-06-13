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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('room_id')->constrained('rooms');
            $table->string('no_booking');
            $table->date('checkIn');
            $table->date('checkOut');
            $table->integer('total');
            $table->integer('total_dewasa');
            $table->integer('total_anak');
            $table->text('pesan');
            $table->string('metode_pembayaran');
            $table->string('status');
            $table->string('kondisi');
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
        Schema::dropIfExists('bookings');
    }
};
