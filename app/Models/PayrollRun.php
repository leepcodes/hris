<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollRun extends Model
{
    use HasFactory;

    protected $fillable = ['payroll_period_id', 'status', 'prepared_by', 'reviewed_by', 'approved_by', 'prepared_at', 'reviewed_at', 'approved_at', 'released_at'];

    protected function casts(): array
    {
        return ['prepared_at' => 'datetime', 'reviewed_at' => 'datetime', 'approved_at' => 'datetime', 'released_at' => 'datetime'];
    }

    public function payrollPeriod(): BelongsTo
    {
        return $this->belongsTo(PayrollPeriod::class);
    }
}
