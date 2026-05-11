<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_item_breakdowns', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('payroll_run_item_id')->index();
            $table->string('category')->index();
            $table->string('code')->index();
            $table->decimal('amount', 12, 2)->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_item_breakdowns');
    }
};
