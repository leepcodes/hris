<?php

namespace Database\Seeders;

use App\Models\AttendanceImportBatch;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $uploader = User::query()->where('email', 'admin@hris.local')->first() ?? User::query()->first();

        if (! $uploader) {
            return;
        }

        $employees = Employee::query()->orderBy('id')->limit(5)->get();

        if ($employees->isEmpty()) {
            return;
        }

        AttendanceRecord::query()->delete();
        AttendanceImportBatch::query()->where('filename', 'seeded-attendance-cutoff-1.csv')->orWhere('filename', 'seeded-attendance-cutoff-2.csv')->delete();

        $currentYear = now()->year;
        $currentMonth = now()->month;

        $cutoffs = [
            ['filename' => 'seeded-attendance-cutoff-1.csv', 'start_day' => 1, 'end_day' => 15],
            ['filename' => 'seeded-attendance-cutoff-2.csv', 'start_day' => 16, 'end_day' => 30],
        ];

        foreach ($cutoffs as $cutoff) {
            $days = $cutoff['end_day'] - $cutoff['start_day'] + 1;

            $batch = AttendanceImportBatch::query()->create([
                'filename' => $cutoff['filename'],
                'uploaded_by' => $uploader->id,
                'status' => 'imported',
                'total_rows' => $employees->count() * $days,
                'valid_rows' => $employees->count() * $days,
                'invalid_rows' => 0,
                'row_errors' => [],
                'imported_at' => now(),
            ]);

            foreach ($employees as $employee) {
                for ($day = $cutoff['start_day']; $day <= $cutoff['end_day']; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);

                    AttendanceRecord::query()->create([
                        'attendance_import_batch_id' => $batch->id,
                        'employee_id' => $employee->id,
                        'employee_code' => $employee->employee_code,
                        'attendance_date' => $date,
                        'time_in' => '08:00:00',
                        'time_out' => '17:00:00',
                        'break_hours' => 1,
                        'late_minutes' => $day % 7 === 0 ? 15 : 0,
                        'undertime_minutes' => 0,
                        'is_absent' => false,
                        'overtime_hours' => $day % 10 === 0 ? 2 : 0,
                    ]);
                }
            }
        }
    }
}
