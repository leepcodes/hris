<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'default_interest_rate', 'is_active'];

    protected function casts(): array
    {
        return ['default_interest_rate' => 'decimal:4', 'is_active' => 'boolean'];
    }
}
