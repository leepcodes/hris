<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAttendanceCsvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('attendance.upload');
    }

    public function rules(): array
    {
        return [
            'attendance_csv' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }
}
