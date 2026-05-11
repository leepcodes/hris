<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'is_paid', 'accrual_rate', 'is_active'];

    protected function casts(): array
    {
        return ['is_paid' => 'boolean', 'is_active' => 'boolean', 'accrual_rate' => 'decimal:2'];
    }
}
