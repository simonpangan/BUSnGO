<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('ticket_cost');
            $table->unsignedBigInteger('terminal_id');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->unsignedInteger('driver_id');
            $table->unsignedInteger('conductor_id');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
