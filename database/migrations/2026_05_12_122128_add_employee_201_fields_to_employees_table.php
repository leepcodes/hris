<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table): void {
            $table->string('civil_status')->nullable()->after('suffix_name');
            $table->date('birth_date')->nullable()->after('civil_status');
            $table->string('gender')->nullable()->after('birth_date');
            $table->text('address_line')->nullable()->after('mobile_number');
            $table->string('city')->nullable()->after('address_line');
            $table->string('province')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('province');
            $table->string('emergency_contact_name')->nullable()->after('zip_code');
            $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_relationship');
            $table->string('sss_no')->nullable()->after('emergency_contact_number');
            $table->string('philhealth_no')->nullable()->after('sss_no');
            $table->string('pagibig_no')->nullable()->after('philhealth_no');
            $table->string('tin_no')->nullable()->after('pagibig_no');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table): void {
            $table->dropColumn([
                'civil_status',
                'birth_date',
                'gender',
                'address_line',
                'city',
                'province',
                'zip_code',
                'emergency_contact_name',
                'emergency_contact_relationship',
                'emergency_contact_number',
                'sss_no',
                'philhealth_no',
                'pagibig_no',
                'tin_no',
            ]);
        });
    }
};
