<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'frequency', 'start_date', 'end_date', 'status', 'locked_at'];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date', 'locked_at' => 'datetime'];
    }
}
