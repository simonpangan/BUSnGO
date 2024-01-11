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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name', 45);
            $table->char('gender', 1);
            $table->string('address', 45);
            $table->string('city', 45);
            $table->string('contact_no', 45);
            $table->string('photo');

//            $table->text('password');
//            $table->string('email', 45)->unique();

//            $table->string('username', 45);
//            $table->string('question', 400);
//            $table->string('answer', 45);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
