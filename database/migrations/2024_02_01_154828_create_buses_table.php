<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->integer('seat');
            $table->string('engine_model');
            $table->string('chassis_no');
            $table->string('model');
            $table->string('color');
            $table->string('register_no');
            $table->string('made_in');
            $table->string('make');
            $table->string('price');
            $table->string('fuel');
            $table->string('engine_capacity');
            $table->integer('puchase_year');
            $table->string('transmission_model');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
