<?php

namespace App\Http\Requests;

use App\Models\JobPosition;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobPositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', JobPosition::class);
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'salary_grade' => ['nullable', 'string', 'max:50'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
