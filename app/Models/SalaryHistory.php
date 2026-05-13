<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'job_position_id',
        'basic_salary',
        'effective_date',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'basic_salary' => 'decimal:2',
            'effective_date' => 'date',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }
}
