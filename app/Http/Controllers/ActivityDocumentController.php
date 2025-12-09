<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityDocument;
use App\Models\Student;
use App\Models\Company;
use App\Models\ActivityType;
use Illuminate\Support\Facades\Storage;

class ActivityDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityDocument::with(['student', 'company', 'activityType']);

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter by activity type
        if ($request->filled('activity_type_id')) {
            $query->where('activity_type_id', $request->activity_type_id);
        }

        $activities = $query->latest('activity_date')->paginate(15);
        $students = Student::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $activityTypes = ActivityType::orderBy('name')->get();

        return view('activity-documents.index', compact('activities', 'students', 'companies', 'activityTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $activityTypes = ActivityType::orderBy('name')->get();
        
        return view('activity-documents.create', compact('students', 'companies', 'activityTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'company_id' => 'nullable|exists:companies,id',
            'activity_type_id' => 'required|exists:activity_types,id',
            'activity_date' => 'required|date',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            'notes' => 'nullable|string',
        ]);

        // Store the file if provided
        $path = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('activities', $filename, 'public');
        }

        // Create activity record
        $activity = ActivityDocument::create([
            'student_id' => $validated['student_id'] ?? null,
            'company_id' => $validated['company_id'] ?? null,
            'activity_type_id' => $validated['activity_type_id'],
            'activity_date' => $validated['activity_date'],
            'description' => $validated['description'],
            'file_path' => $path,
            'notes' => $validated['notes'] ?? null,
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('activity-documents.index')
            ->with('success', 'Activity logged successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityDocument $activityDocument)
    {
        $activityDocument->load(['student', 'company', 'activityType', 'recordedBy']);
        
        return view('activity-documents.show', compact('activityDocument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityDocument $activityDocument)
    {
        $students = Student::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $activityTypes = ActivityType::orderBy('name')->get();
        
        return view('activity-documents.edit', compact('activityDocument', 'students', 'companies', 'activityTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityDocument $activityDocument)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'company_id' => 'nullable|exists:companies,id',
            'activity_type_id' => 'required|exists:activity_types,id',
            'activity_date' => 'required|date',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string',
        ]);

        // If new file is uploaded, delete old one and store new
        if ($request->hasFile('file')) {
            // Delete old file
            if ($activityDocument->file_path) {
                Storage::disk('public')->delete($activityDocument->file_path);
            }

            // Store new file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('activities', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $activityDocument->update($validated);

        return redirect()->route('activity-documents.index')
            ->with('success', 'Activity updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityDocument $activityDocument)
    {
        // Delete the file if exists
        if ($activityDocument->file_path) {
            Storage::disk('public')->delete($activityDocument->file_path);
        }

        $activityDocument->delete();

        return redirect()->route('activity-documents.index')
            ->with('success', 'Activity deleted successfully!');
    }

    /**
     * Download the activity document file
     */
    public function download(ActivityDocument $activityDocument)
    {
        if (!$activityDocument->file_path || !Storage::disk('public')->exists($activityDocument->file_path)) {
            abort(404, 'File not found');
        }

        return response()->download(storage_path('app/public/' . $activityDocument->file_path));
    }
}
