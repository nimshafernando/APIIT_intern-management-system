<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkLog;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkLog::with(['student', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $workLogs = $query->latest()->paginate(20);
        $students = Student::orderBy('name')->get();

        return view('work-logs.index', compact('workLogs', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('work-logs.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'week_number' => 'required|integer|min:1',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'hours_worked' => 'required|numeric|min:0|max:168',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('work-logs', 'public');
        }

        $workLog = WorkLog::create($validated);

        return redirect()->route('work-logs.show', $workLog)
            ->with('success', 'Work log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkLog $workLog)
    {
        $workLog->load(['student', 'reviewer']);

        return view('work-logs.show', compact('workLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLog $workLog)
    {
        $students = Student::orderBy('name')->get();
        return view('work-logs.edit', compact('workLog', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkLog $workLog)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'week_number' => 'required|integer|min:1',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'hours_worked' => 'required|numeric|min:0|max:168',
            'description' => 'required|string',
            'status' => 'required|in:Submitted,Reviewed,Approved,Rejected',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);
        if ($request->hasFile('file')) {
            if ($workLog->file_path) {
                Storage::disk('public')->delete($workLog->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('work-logs', 'public');
        }

        $validated['reviewed_by'] = Auth::id();
        $workLog->update($validated);
        $workLog->update($validated);

        return redirect()->route('work-logs.show', $workLog)
            ->with('success', 'Work log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $workLog)
    {
        if ($workLog->file_path) {
            Storage::disk('public')->delete($workLog->file_path);
        }

        $workLog->delete();

        return redirect()->route('work-logs.index')
            ->with('success', 'Work log deleted successfully.');
    }
}
