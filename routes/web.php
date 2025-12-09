<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\ActivityDocumentController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\OpportunityAnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Students Module
    Route::get('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('students/import/process', [StudentController::class, 'processImport'])->name('students.import.process');
    Route::resource('students', StudentController::class);
    
    // Companies Module
    Route::resource('companies', CompanyController::class);
    
    // Applications (CV Tracking) Module
    Route::resource('applications', ApplicationController::class);
    
    // Student Documents Module
    Route::get('student-documents/{studentDocument}/download', [StudentDocumentController::class, 'download'])->name('student-documents.download');
    Route::resource('student-documents', StudentDocumentController::class);
    
    // Activity Documents Module
    Route::get('activity-documents/{activityDocument}/download', [ActivityDocumentController::class, 'download'])->name('activity-documents.download');
    Route::resource('activity-documents', ActivityDocumentController::class);
    
    // Work Logs Module
    Route::resource('work-logs', WorkLogController::class);
    
    // Opportunity Announcements Module
    Route::post('opportunities/{opportunity}/mark-filled', [OpportunityAnnouncementController::class, 'markAsFilled'])->name('opportunities.mark-filled');
    Route::get('opportunities/{opportunity}/apply-students', [OpportunityAnnouncementController::class, 'applyStudents'])->name('opportunities.apply-students');
    Route::post('opportunities/{opportunity}/apply-students', [OpportunityAnnouncementController::class, 'storeStudentApplications'])->name('opportunities.store-applications');
    Route::resource('opportunities', OpportunityAnnouncementController::class);
});

require __DIR__.'/auth.php';
