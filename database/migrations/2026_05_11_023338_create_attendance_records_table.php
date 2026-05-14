<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('attendance_import_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('department')->index();
            $table->string('name')->index();
            $table->string('employee_no')->index();         
            $table->string('date_time')->nullable(); 
            $table->string('status')->nullable();    
            $table->string('location')->nullable();  
            $table->string('id_number')->nullable(); 
            $table->string('verification_code')->nullable(); 
            $table->timestamps();

            $table->index(['employee_id', 'employee_no']);    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};