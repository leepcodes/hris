<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWorkHistory extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'company_name', 'position_title', 'started_at', 'ended_at', 'last_salary', 'notes'];

    protected function casts(): array
    {
        return ['started_at' => 'date', 'ended_at' => 'date', 'last_salary' => 'decimal:2'];
    }
}
