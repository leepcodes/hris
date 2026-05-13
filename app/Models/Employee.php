<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_code',
        'user_id',
        'department_id',
        'job_position_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'civil_status',
        'birth_date',
        'gender',
        'email',
        'mobile_number',
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
        'employment_status',
        'hired_at',
        'basic_salary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'hired_at' => 'date',
            'birth_date' => 'date',
            'basic_salary' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function salaryHistories(): HasMany
    {
        return $this->hasMany(SalaryHistory::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(EmployeeDependent::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function workHistories(): HasMany
    {
        return $this->hasMany(EmployeeWorkHistory::class);
    }
}
