<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\Company;
use App\Models\OpportunityAnnouncement;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Application::with(['student', 'company', 'opportunityAnnouncement']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $applications = $query->latest()->paginate(20);
        $companies = Company::orderBy('name')->get();
        $students = Student::orderBy('name')->get();

        return view('applications.index', compact('applications', 'companies', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $students = Student::with(['documents' => function($query) {
            $query->whereHas('documentType', function($q) {
                $q->where('name', 'CVs');
            });
        }, 'documents.documentType'])->orderBy('name')->get();
        $companies = Company::orderBy('name')->get();

        // Get opportunity if provided
        $opportunity = null;
        $preselectedCompanyId = null;
        if ($request->filled('opportunity_id')) {
            $opportunity = OpportunityAnnouncement::with('company')->find($request->opportunity_id);
            if ($opportunity) {
                $preselectedCompanyId = $opportunity->company_id;
            }
        }

        return view('applications.create', compact('students', 'companies', 'opportunity', 'preselectedCompanyId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:companies,id',
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:Pending,CV Sent,Shortlisted,Interview,Offer Sent,Rejected,Approved,Completed',
            'sent_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            $validated['cv_file_path'] = $request->file('cv_file')->store('cvs', 'public');
        }

        $application = Application::create($validated);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $application->load(['student', 'company', 'opportunityAnnouncement']);

        return view('applications.show', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'company_id' => 'sometimes|required|exists:companies,id',
            'position' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:Pending,CV Sent,Shortlisted,Interview,Offer Sent,Rejected,Approved,Completed',
            'sent_date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            // Delete old file if exists
            if ($application->cv_file_path) {
                Storage::disk('public')->delete($application->cv_file_path);
            }
            $validated['cv_file_path'] = $request->file('cv_file')->store('cvs', 'public');
        }

        $application->update($validated);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        if ($application->cv_file_path) {
            Storage::disk('public')->delete($application->cv_file_path);
        }

        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}
