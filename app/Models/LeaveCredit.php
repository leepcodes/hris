<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCredit extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'leave_type_id', 'balance', 'used'];

    protected function casts(): array
    {
        return ['balance' => 'decimal:2', 'used' => 'decimal:2'];
    }
}
