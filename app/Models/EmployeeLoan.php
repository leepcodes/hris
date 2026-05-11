<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLoan extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'loan_type_id', 'principal_amount', 'amortization_amount', 'balance_amount', 'start_date', 'end_date', 'status'];

    protected function casts(): array
    {
        return ['principal_amount' => 'decimal:2', 'amortization_amount' => 'decimal:2', 'balance_amount' => 'decimal:2', 'start_date' => 'date', 'end_date' => 'date'];
    }
}
