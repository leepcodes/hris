<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGovernmentDeductionConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deduction_type' => ['required', 'in:sss,philhealth,pagibig,withholding_tax'],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'config.salary_min' => ['required', 'numeric', 'min:0'],
            'config.salary_max' => ['required', 'numeric', 'gt:config.salary_min'],
            'config.employee_share' => ['required', 'numeric', 'min:0'],
        ];
    }
}
