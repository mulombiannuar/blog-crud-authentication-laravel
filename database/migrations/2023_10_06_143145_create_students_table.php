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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 150)->unique();
            $table->string('mobile_number', 150)->unique();
            $table->string('course', 150);
            $table->foreignId('user_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status')->default(0);
            $table->string('password');
            $table->string('image')->default('avatar.png');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
