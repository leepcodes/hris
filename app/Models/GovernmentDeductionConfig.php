<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentDeductionConfig extends Model
{
    use HasFactory;

    protected $fillable = ['deduction_type', 'name', 'config', 'effective_date', 'is_active'];

    protected function casts(): array
    {
        return ['config' => 'array', 'effective_date' => 'date', 'is_active' => 'boolean'];
    }
}
