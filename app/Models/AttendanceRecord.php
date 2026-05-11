<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_import_batch_id',
        'employee_id',
        'employee_code',
        'attendance_date',
        'time_in',
        'time_out',
        'break_hours',
        'late_minutes',
        'undertime_minutes',
        'is_absent',
        'overtime_hours',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'is_absent' => 'boolean',
            'break_hours' => 'decimal:2',
            'overtime_hours' => 'decimal:2',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(AttendanceImportBatch::class, 'attendance_import_batch_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
