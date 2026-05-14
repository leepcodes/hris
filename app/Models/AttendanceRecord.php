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
        'department',
        'name',
        'employee_no',
        'date_time',
        'status',
        'location',
        'id_number',
        'verification_code',
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
