<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceImportBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'uploaded_by',
        'status',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'row_errors',
        'imported_at',
    ];

    protected function casts(): array
    {
        return [
            'row_errors' => 'array',
            'imported_at' => 'datetime',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
