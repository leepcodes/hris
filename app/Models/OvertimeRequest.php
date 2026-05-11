<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'ot_date', 'start_time', 'end_time', 'hours', 'reason', 'status', 'approved_by', 'approved_at'];

    protected function casts(): array
    {
        return ['ot_date' => 'date', 'approved_at' => 'datetime', 'hours' => 'decimal:2'];
    }
}
