<?php

namespace App\Http\Controllers;

use App\Models\OpportunityAnnouncement;
use App\Models\Company;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpportunityAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Auto-expire opportunities
        OpportunityAnnouncement::where('status', 'Open')
            ->where('deadline', '<', now()->toDateString())
            ->update(['status' => 'Expired']);

        $query = OpportunityAnnouncement::with('company');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%")
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $opportunities = $query->latest('announced_at')->paginate(15);
        $companies = Company::orderBy('name')->get();

        return view('opportunities.index', compact('opportunities', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('opportunities.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|string|max:100',
            'skills' => 'nullable|string',
            'deadline' => 'nullable|date',
            'announced_at' => 'required|date',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'remarks' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('opportunity_documents', 'public');
        }

        // Ensure roles is always an array (default to empty array if not provided)
        $validated['roles'] = $validated['roles'] ?? [];

        OpportunityAnnouncement::create($validated);

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunity announcement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OpportunityAnnouncement $opportunity)
    {
        // Auto-expire check
        if ($opportunity->isExpired() && $opportunity->status === 'Open') {
            $opportunity->update(['status' => 'Expired']);
        }

        $opportunity->load(['company', 'applications.student']);
        return view('opportunities.show', compact('opportunity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpportunityAnnouncement $opportunity)
    {
        $companies = Company::orderBy('name')->get();
        return view('opportunities.edit', compact('opportunity', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpportunityAnnouncement $opportunity)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|string|max:100',
            'skills' => 'nullable|string',
            'deadline' => 'nullable|date',
            'announced_at' => 'required|date',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status' => 'required|in:Open,Closed,Filled,Expired',
            'remarks' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($opportunity->document_path) {
                Storage::disk('public')->delete($opportunity->document_path);
            }
            $validated['document_path'] = $request->file('document')->store('opportunity_documents', 'public');
        }

        // Ensure roles is always an array (default to empty array if not provided)
        $validated['roles'] = $validated['roles'] ?? [];

        $opportunity->update($validated);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Opportunity announcement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpportunityAnnouncement $opportunity)
    {
        // Delete associated document
        if ($opportunity->document_path) {
            Storage::disk('public')->delete($opportunity->document_path);
        }

        $opportunity->delete();

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunity announcement deleted successfully.');
    }

    /**
     * Mark opportunity as filled.
     */
    public function markAsFilled(OpportunityAnnouncement $opportunity)
    {
        $opportunity->update(['status' => 'Filled']);

        return redirect()->back()
            ->with('success', 'Opportunity marked as filled.');
    }

    /**
     * Show form to apply students to opportunity.
     */
    public function applyStudents(OpportunityAnnouncement $opportunity)
    {
        $opportunity->load('company');
        
        // Get students with matching interests if roles are specified
        $studentsQuery = Student::query();
        
        if (!empty($opportunity->roles)) {
            $studentsQuery->whereHas('interests', function($query) use ($opportunity) {
                $query->whereIn('job_role', $opportunity->roles);
            });
        }
        
        $matchingStudents = $studentsQuery->with('interests')->orderBy('name')->get();
        
        // Get all other students
        $allStudents = Student::with('interests')->orderBy('name')->get();
        
        return view('opportunities.apply-students', compact('opportunity', 'matchingStudents', 'allStudents'));
    }

    /**
     * Store applications for multiple students.
     */
    public function storeStudentApplications(Request $request, OpportunityAnnouncement $opportunity)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'position' => 'nullable|string|max:255',
        ]);

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($validated['student_ids'] as $studentId) {
            // Check if application already exists for this specific opportunity
            $exists = Application::where('student_id', $studentId)
                ->where('opportunity_announcement_id', $opportunity->id)
                ->exists();

            if (!$exists) {
                Application::create([
                    'student_id' => $studentId,
                    'company_id' => $opportunity->company_id,
                    'opportunity_announcement_id' => $opportunity->id,
                    'position' => $validated['position'] ?? implode(', ', $opportunity->roles ?? []),
                    'status' => 'Pending',
                    'sent_date' => now(),
                ]);
                $createdCount++;
            } else {
                $skippedCount++;
            }
        }

        $message = "{$createdCount} application(s) created successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} student(s) already have applications for this opportunity.";
        }

        return redirect()->route('applications.index')
            ->with('success', $message);
    }
}
