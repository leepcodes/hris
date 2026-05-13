<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_work_histories', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->string('company_name');
            $table->string('position_title')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->decimal('last_salary', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_work_histories');
    }
};
