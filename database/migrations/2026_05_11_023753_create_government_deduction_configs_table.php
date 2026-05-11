<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('government_deduction_configs', function (Blueprint $table): void {
            $table->id();
            $table->string('deduction_type')->index();
            $table->string('name');
            $table->json('config')->nullable();
            $table->date('effective_date')->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('government_deduction_configs');
    }
};
