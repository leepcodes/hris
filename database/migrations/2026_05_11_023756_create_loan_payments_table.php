<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_payments', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('employee_loan_id')->index();
            $table->unsignedBigInteger('payroll_run_id')->nullable()->index();
            $table->date('payment_date')->index();
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
