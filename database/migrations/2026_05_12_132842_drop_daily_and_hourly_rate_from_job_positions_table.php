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
        Schema::table('job_positions', function (Blueprint $table) {
            $table->dropColumn(['daily_rate', 'hourly_rate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->decimal('daily_rate', 12, 2)->default(0)->after('basic_salary');
            $table->decimal('hourly_rate', 12, 2)->default(0)->after('daily_rate');
        });
    }
};
