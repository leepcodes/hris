<?php

namespace App\Services;

use App\Models\AttendanceImportBatch;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class AttendanceCsvImportService
{
    /**
     * @return array{headers: array<int, string>, valid_rows: array<int, array<string, mixed>>, errors: array<int, array<string, mixed>>, total_rows: int}
     */
    public function preview(UploadedFile $file): array
    {
        $rows = array_map('str_getcsv', file($file->getRealPath()) ?: []);

        if ($rows === []) {
            return ['headers' => [], 'valid_rows' => [], 'errors' => [['row' => 0, 'message' => 'CSV is empty.']], 'total_rows' => 0];
        }

        $headers = array_map(fn ($value) => strtolower(trim((string) $value)), array_shift($rows));

        $requiredHeaders = [
            'employee_code',
            'date',
            'time_in',
            'time_out',
            'break_hours',
            'late_minutes',
            'undertime_minutes',
            'absences',
            'overtime_hours',
        ];

        $missingHeaders = array_values(array_diff($requiredHeaders, $headers));

        if ($missingHeaders !== []) {
            return [
                'headers' => $headers,
                'valid_rows' => [],
                'errors' => [['row' => 0, 'message' => 'Missing required headers: '.implode(', ', $missingHeaders)]],
                'total_rows' => count($rows),
            ];
        }

        $validRows = [];
        $errors = [];
        $employeeMap = Employee::query()->pluck('id', 'employee_code')->toArray();

        foreach ($rows as $index => $rawRow) {
            if ($rawRow === [] || (count($rawRow) === 1 && trim((string) $rawRow[0]) === '')) {
                continue;
            }

            $rowNumber = $index + 2;
            $row = array_combine($headers, array_pad($rawRow, count($headers), null));

            if (! $row || blank($row['employee_code']) || blank($row['date'])) {
                $errors[] = ['row' => $rowNumber, 'message' => 'Employee code and date are required.', 'row_data' => $rawRow];
                continue;
            }

            if (! isset($employeeMap[$row['employee_code']])) {
                $errors[] = ['row' => $rowNumber, 'message' => 'Employee code not found.', 'row_data' => $rawRow];
                continue;
            }

            $date = date_create((string) $row['date']);

            if (! $date) {
                $errors[] = ['row' => $rowNumber, 'message' => 'Invalid attendance date.', 'row_data' => $rawRow];
                continue;
            }

            $validRows[] = [
                'employee_id' => $employeeMap[$row['employee_code']],
                'employee_code' => trim((string) $row['employee_code']),
                'attendance_date' => $date->format('Y-m-d'),
                'time_in' => $this->normalizeTime($row['time_in']),
                'time_out' => $this->normalizeTime($row['time_out']),
                'break_hours' => (float) ($row['break_hours'] ?: 0),
                'late_minutes' => (int) ($row['late_minutes'] ?: 0),
                'undertime_minutes' => (int) ($row['undertime_minutes'] ?: 0),
                'is_absent' => (int) ($row['absences'] ?: 0) > 0,
                'overtime_hours' => (float) ($row['overtime_hours'] ?: 0),
            ];
        }

        return [
            'headers' => $headers,
            'valid_rows' => $validRows,
            'errors' => $errors,
            'total_rows' => count($rows),
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $validRows
     * @param array<int, array<string, mixed>> $errors
     */
    public function import(string $filename, int $uploadedBy, array $validRows, array $errors): AttendanceImportBatch
    {
        return DB::transaction(function () use ($filename, $uploadedBy, $validRows, $errors): AttendanceImportBatch {
            $batch = AttendanceImportBatch::query()->create([
                'filename' => $filename,
                'uploaded_by' => $uploadedBy,
                'status' => 'imported',
                'total_rows' => count($validRows) + count($errors),
                'valid_rows' => count($validRows),
                'invalid_rows' => count($errors),
                'row_errors' => $errors,
                'imported_at' => now(),
            ]);

            foreach ($validRows as $row) {
                AttendanceRecord::query()->create([
                    'attendance_import_batch_id' => $batch->id,
                    ...$row,
                ]);
            }

            return $batch;
        });
    }

    private function normalizeTime(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $timestamp = strtotime((string) $value);

        if ($timestamp === false) {
            return null;
        }

        return date('H:i:s', $timestamp);
    }
}
