<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conductors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->integer('user_id');
            $table->string('name', 45);
            $table->char('gender', 1);
            $table->string('address', 100);
            $table->string('city', 45);
            $table->string('contact_no', 45);
            $table->string('photo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductors');
    }
};
