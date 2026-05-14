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

        $rawHeaders = array_shift($rows);
        $headers = array_map(fn ($value) => $this->normalizeHeader((string) $value), $rawHeaders);
        // dd($headers);
        $requiredHeaders = [
            'department',
            'name',
            'no',
            'date_time',
            'status',
            'location',       
            'id_number',
            'verification_code', 
        ];

        $missingHeaders = array_values(array_diff($requiredHeaders, $headers));

        if ($missingHeaders !== []) {
            return [
                'headers' => $headers,
                'valid_rows' => [],
                'errors' => [['row' => 0, 'message' => 'Missing required headers: ' . implode(', ', $missingHeaders)]],
                'total_rows' => count($rows),
            ];
        }

        $validRows = [];
        $errors = [];

        foreach ($rows as $index => $rawRow) {
            if ($rawRow === [] || (count($rawRow) === 1 && trim((string) $rawRow[0]) === '')) {
                continue;
            }

            $rowNumber = $index + 2;
            $row = array_combine($headers, array_pad($rawRow, count($headers), null));

            if (! $row || blank($row['no']) || blank($row['name'])) {
                $errors[] = ['row' => $rowNumber, 'message' => 'No and Name are required.', 'row_data' => $rawRow];
                continue;
            }

            $validRows[] = [
                'department'        => trim((string) $row['department']),
                'name'              => trim((string) $row['name']),
                'employee_no'       => trim((string) $row['no']),
                'date_time'         => trim((string) ($row['date_time'] ?? '')),
                'status'            => trim((string) ($row['status'] ?? '')),
                'location'          => trim((string) ($row['location'] ?? '')),   // came from location_id
                'id_number'         => trim((string) ($row['id_number'] ?? '')),
                'verification_code' => trim((string) ($row['verification_code'] ?? '')),
            ];
        }

        return [
            'headers'    => $headers,
            'valid_rows' => $validRows,
            'errors'     => $errors,
            'total_rows' => count($rows),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $validRows
     * @param  array<int, array<string, mixed>>  $errors
     */
    public function import(string $filename, int $uploadedBy, array $validRows, array $errors): AttendanceImportBatch
    {
        return DB::transaction(function () use ($filename, $uploadedBy, $validRows, $errors): AttendanceImportBatch {
            $batch = AttendanceImportBatch::query()->create([
                'filename'    => $filename,
                'uploaded_by' => $uploadedBy,
                'status'      => 'imported',
                'total_rows'  => count($validRows) + count($errors),
                'valid_rows'  => count($validRows),
                'invalid_rows' => count($errors),
                'row_errors'  => $errors,
                'imported_at' => now(),
            ]);
            // dd($validRows[0] ?? 'empty');
           foreach ($validRows as $row) {
                AttendanceRecord::query()->create([
                    'attendance_import_batch_id' => $batch->id,
                    'employee_no'              => $row['employee_no'],  
                    'department'                 => $row['department'],
                    'name'                       => $row['name'],
                    'date_time'                  => $row['date_time'],
                    'status'                     => $row['status'],
                    'location'                   => $row['location'],
                    'id_number'                  => $row['id_number'],
                    'verification_code'          => $row['verification_code'],
                ]);
            }

            return $batch;
        });
    }

    
    private function normalizeHeader(string $header): string
    {
        $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header);
        $header = trim((string) $header);

        $map = [
            'Date/Time'   => 'date_time',
            'ID Number'   => 'id_number',
            'Location ID' => 'location',
            'VerifyCode'  => 'verification_code',
            'No.'         => 'no',
        ];

        foreach ($map as $raw => $normalized) {
            if (strcasecmp($header, $raw) === 0) {
                return $normalized;
            }
        }

        $header = preg_replace('/[^a-zA-Z0-9]+/', ' ', $header);
        $header = trim((string) $header);
        $header = preg_replace('/\s+/', '_', $header);

        return strtolower((string) $header);
    }
}