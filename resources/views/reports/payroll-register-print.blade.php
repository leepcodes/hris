<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Register Run #{{ $runId }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 12px; }
        @media print { .no-print { display:none; } }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()">Print</button>
    <h2>Payroll Register - Run #{{ $runId }}</h2>
    <table>
        <thead><tr><th>Employee</th><th>Gross</th><th>Deductions</th><th>Net</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->employee?->last_name }}, {{ $item->employee?->first_name }}</td>
                <td>{{ number_format((float)$item->gross_pay,2) }}</td>
                <td>{{ number_format((float)$item->total_deductions,2) }}</td>
                <td>{{ number_format((float)$item->net_pay,2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
