<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentDocument;
use App\Models\Student;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StudentDocument::with(['student', 'documentType']);

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by document type
        if ($request->filled('document_type_id')) {
            $query->where('document_type_id', $request->document_type_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->latest()->paginate(15);
        $students = Student::orderBy('name')->get();
        $documentTypes = DocumentType::orderBy('name')->get();

        return view('student-documents.index', compact('documents', 'students', 'documentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $documentTypes = DocumentType::orderBy('name')->get();
        
        return view('student-documents.create', compact('students', 'documentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            'remarks' => 'nullable|string',
        ]);

        // Store the file
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');

        // Create document record
        $document = StudentDocument::create([
            'student_id' => $validated['student_id'],
            'document_type_id' => $validated['document_type_id'],
            'file_path' => $path,
            'status' => 'Uploaded',
            'remarks' => $validated['remarks'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('student-documents.index')
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentDocument $studentDocument)
    {
        $studentDocument->load(['student', 'documentType', 'uploadedBy']);
        
        return view('student-documents.show', compact('studentDocument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentDocument $studentDocument)
    {
        $students = Student::orderBy('name')->get();
        $documentTypes = DocumentType::orderBy('name')->get();
        
        return view('student-documents.edit', compact('studentDocument', 'students', 'documentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentDocument $studentDocument)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required|in:Uploaded,Verified,Rejected',
            'remarks' => 'nullable|string',
        ]);

        // If new file is uploaded, delete old one and store new
        if ($request->hasFile('file')) {
            // Delete old file
            if ($studentDocument->file_path) {
                Storage::disk('public')->delete($studentDocument->file_path);
            }

            // Store new file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $studentDocument->update($validated);

        return redirect()->route('student-documents.index')
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentDocument $studentDocument)
    {
        // Delete the file
        if ($studentDocument->file_path) {
            Storage::disk('public')->delete($studentDocument->file_path);
        }

        $studentDocument->delete();

        return redirect()->route('student-documents.index')
            ->with('success', 'Document deleted successfully!');
    }

    /**
     * Download the document file
     */
    public function download(StudentDocument $studentDocument)
    {
        if (!$studentDocument->file_path || !Storage::disk('public')->exists($studentDocument->file_path)) {
            abort(404, 'File not found');
        }

        return response()->download(storage_path('app/public/' . $studentDocument->file_path));
    }
}
