<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDependent extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'full_name', 'relationship', 'birth_date'];

    protected function casts(): array
    {
        return ['birth_date' => 'date'];
    }
}
