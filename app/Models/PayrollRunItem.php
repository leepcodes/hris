<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollRunItem extends Model
{
    use HasFactory;

    protected $fillable = ['payroll_run_id', 'employee_id', 'gross_pay', 'taxable_income', 'total_deductions', 'net_pay', 'snapshot'];

    protected function casts(): array
    {
        return ['gross_pay' => 'decimal:2', 'taxable_income' => 'decimal:2', 'total_deductions' => 'decimal:2', 'net_pay' => 'decimal:2', 'snapshot' => 'array'];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class);
    }
}
