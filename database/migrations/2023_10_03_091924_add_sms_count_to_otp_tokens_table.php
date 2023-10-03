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
        Schema::table('otp_tokens', function (Blueprint $table) {
            $table->string('sms_count')->default(1)->after('session_otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('otp_tokens', function (Blueprint $table) {
            $table->dropColumn('sms_count');
        });
    }
};
