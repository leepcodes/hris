<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItemBreakdown extends Model
{
    use HasFactory;

    protected $fillable = ['payroll_run_item_id', 'category', 'code', 'amount', 'meta'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'meta' => 'array'];
    }
}
