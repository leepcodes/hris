<?php

use App\Http\Controllers\AttendanceImportController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EssController;
use App\Http\Controllers\GovernmentDeductionConfigController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\LeaveManagementController;
use App\Http\Controllers\LoanManagementController;
use App\Http\Controllers\OvertimeManagementController;
use App\Http\Controllers\PayrollPeriodController;
use App\Http\Controllers\PayrollRunController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SystemConfigController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class)->except(['show'])->middleware('permission:users.view');
    Route::resource('employees', EmployeeController::class)->middleware('permission:employees.view');
    Route::post('/employees/{employee}/dependents', [EmployeeController::class, 'addDependent'])->name('employees.dependents.store')->middleware('permission:employees.update');
    Route::delete('/employees/{employee}/dependents/{dependent}', [EmployeeController::class, 'deleteDependent'])->name('employees.dependents.destroy')->middleware('permission:employees.update');
    Route::post('/employees/{employee}/educations', [EmployeeController::class, 'addEducation'])->name('employees.educations.store')->middleware('permission:employees.update');
    Route::delete('/employees/{employee}/educations/{education}', [EmployeeController::class, 'deleteEducation'])->name('employees.educations.destroy')->middleware('permission:employees.update');
    Route::post('/employees/{employee}/work-histories', [EmployeeController::class, 'addWorkHistory'])->name('employees.work-histories.store')->middleware('permission:employees.update');
    Route::delete('/employees/{employee}/work-histories/{workHistory}', [EmployeeController::class, 'deleteWorkHistory'])->name('employees.work-histories.destroy')->middleware('permission:employees.update');
    Route::post('/employees/{employee}/documents', [EmployeeController::class, 'uploadDocument'])->name('employees.documents.store')->middleware('permission:employees.update');
    Route::delete('/employees/{employee}/documents/{document}', [EmployeeController::class, 'deleteDocument'])->name('employees.documents.destroy')->middleware('permission:employees.update');

    Route::resource('departments', DepartmentController::class)->except(['show'])->middleware('permission:departments.view');
    Route::resource('job-positions', JobPositionController::class)->except(['show'])->middleware('permission:job_positions.view');

    Route::get('/attendance-imports', [AttendanceImportController::class, 'index'])->name('attendance-imports.index')->middleware('permission:attendance.view');
    Route::post('/attendance-imports/preview', [AttendanceImportController::class, 'preview'])->name('attendance-imports.preview')->middleware('permission:attendance.upload');
    Route::post('/attendance-imports', [AttendanceImportController::class, 'store'])->name('attendance-imports.store')->middleware('permission:attendance.upload');
    Route::resource('attendance-records', AttendanceRecordController::class)->only(['index', 'store', 'edit', 'update', 'destroy'])->middleware('permission:attendance.view');

    Route::resource('gov-deductions', GovernmentDeductionConfigController::class)->except(['show'])->middleware('permission:deductions.view');

    Route::get('/leave', [LeaveManagementController::class, 'index'])->name('leave.index')->middleware('permission:leave.view');
    Route::post('/leave', [LeaveManagementController::class, 'store'])->name('leave.store')->middleware('permission:leave.manage');
    Route::put('/leave/{leaveRequest}', [LeaveManagementController::class, 'update'])->name('leave.update')->middleware('permission:leave.manage');
    Route::delete('/leave/{leaveRequest}', [LeaveManagementController::class, 'destroy'])->name('leave.destroy')->middleware('permission:leave.manage');
    Route::post('/leave/{leaveRequest}/approve', [LeaveManagementController::class, 'approve'])->name('leave.approve')->middleware('permission:leave.manage');
    Route::post('/leave/{leaveRequest}/reject', [LeaveManagementController::class, 'reject'])->name('leave.reject')->middleware('permission:leave.manage');

    Route::get('/overtime', [OvertimeManagementController::class, 'index'])->name('overtime.index')->middleware('permission:overtime.view');
    Route::post('/overtime', [OvertimeManagementController::class, 'store'])->name('overtime.store')->middleware('permission:overtime.manage');
    Route::put('/overtime/{overtimeRequest}', [OvertimeManagementController::class, 'update'])->name('overtime.update')->middleware('permission:overtime.manage');
    Route::delete('/overtime/{overtimeRequest}', [OvertimeManagementController::class, 'destroy'])->name('overtime.destroy')->middleware('permission:overtime.manage');
    Route::post('/overtime/{overtimeRequest}/approve', [OvertimeManagementController::class, 'approve'])->name('overtime.approve')->middleware('permission:overtime.manage');
    Route::post('/overtime/{overtimeRequest}/reject', [OvertimeManagementController::class, 'reject'])->name('overtime.reject')->middleware('permission:overtime.manage');

    Route::get('/loans', [LoanManagementController::class, 'index'])->name('loans.index')->middleware('permission:loans.view');
    Route::post('/loans', [LoanManagementController::class, 'store'])->name('loans.store')->middleware('permission:loans.manage');
    Route::put('/loans/{employeeLoan}', [LoanManagementController::class, 'update'])->name('loans.update')->middleware('permission:loans.manage');
    Route::delete('/loans/{employeeLoan}', [LoanManagementController::class, 'destroy'])->name('loans.destroy')->middleware('permission:loans.manage');
    Route::patch('/loans/{employeeLoan}/status', [LoanManagementController::class, 'updateStatus'])->name('loans.status')->middleware('permission:loans.manage');

    Route::resource('payroll-periods', PayrollPeriodController::class)->except(['show'])->middleware('permission:payroll.view');
    Route::get('/payroll-runs', [PayrollRunController::class, 'index'])->name('payroll-runs.index')->middleware('permission:payroll.view');
    Route::post('/payroll-runs/generate', [PayrollRunController::class, 'generate'])->name('payroll-runs.generate')->middleware('permission:payroll.prepare');
    Route::patch('/payroll-runs/{payrollRun}/transition', [PayrollRunController::class, 'transition'])->name('payroll-runs.transition')->middleware('permission:payroll.approve');
    Route::get('/payslips', [PayslipController::class, 'index'])->name('payslips.index')->middleware('permission:payroll.view');
    Route::get('/payslips/{payslip}', [PayslipController::class, 'show'])->name('payslips.show')->middleware('permission:payroll.view');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:reports.view');
    Route::get('/reports/print/payroll-register', [ReportController::class, 'printPayrollRegister'])->name('reports.print.payroll-register')->middleware('permission:reports.view');
    Route::get('/reports/export/payroll-register', [ReportController::class, 'exportPayrollRegister'])->name('reports.export.payroll-register')->middleware('permission:reports.export');
    Route::get('/ess', [EssController::class, 'index'])->name('ess.index')->middleware('permission:ess.view');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index')->middleware('permission:audit.view');
    Route::get('/system-config', [SystemConfigController::class, 'index'])->name('system-config.index')->middleware('permission:settings.view');
    Route::post('/system-config', [SystemConfigController::class, 'store'])->name('system-config.store')->middleware('permission:settings.update');
    Route::get('/settings', [SystemSettingController::class, 'index'])->name('settings.index')->middleware('permission:settings.view');
    Route::put('/settings/{group}', [SystemSettingController::class, 'update'])->name('settings.update')->middleware('permission:settings.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
