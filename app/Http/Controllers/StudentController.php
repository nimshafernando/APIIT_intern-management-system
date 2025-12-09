<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentInterest;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Filters
        if ($request->filled('batch')) {
            $query->where('batch', $request->batch);
        }

        if ($request->filled('programme')) {
            $query->where('programme', $request->programme);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('student_id', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->latest()->paginate(15);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|string',
            'date_of_birth' => 'nullable|date',
            'profile_photo' => 'nullable|image|max:2048', // 2MB max
            'programme' => 'required|in:SE,CS,CT',
            'batch' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
            'cumulative_marks' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $student = Student::create($validated);

        // Handle interests if provided
        if ($request->has('interests')) {
            foreach ($request->interests as $interest) {
                if (!empty($interest['job_role'])) {
                    $student->interests()->create([
                        'job_role' => $interest['job_role'],
                        'description' => $interest['description'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['interests', 'applications.company', 
                        'documents.documentType', 'workLogs', 'activityDocuments']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load('interests');
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Check if this is an interests-only update
        $isInterestsOnly = $request->has('interests') && !$request->has('student_id');
        
        if (!$isInterestsOnly) {
            // Validate and update student information
            $validated = $request->validate([
                'student_id' => 'required|unique:students,student_id,' . $student->id,
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'phone_number' => 'required|string',
                'date_of_birth' => 'nullable|date',
                'profile_photo' => 'nullable|image|max:2048',
                'programme' => 'required|in:SE,CS,CT',
                'batch' => 'required|string',
                'semester' => 'required|integer|min:1|max:8',
                'cumulative_marks' => 'nullable|numeric|min:0|max:100',
                'notes' => 'nullable|string',
            ]);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($student->profile_photo) {
                    Storage::disk('public')->delete($student->profile_photo);
                }
                $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
            }

            $student->update($validated);
        }

        // Handle interests if provided
        if ($request->has('interests')) {
            // Delete removed interests
            $keepIds = [];
            foreach ($request->interests as $interestData) {
                if (isset($interestData['id']) && !empty($interestData['id'])) {
                    $keepIds[] = $interestData['id'];
                }
            }
            
            if (!empty($keepIds)) {
                $student->interests()->whereNotIn('id', $keepIds)->delete();
            } else {
                // Delete all if no IDs to keep
                $student->interests()->delete();
            }

            // Update or create interests
            foreach ($request->interests as $interestData) {
                if (!empty($interestData['job_role'])) {
                    if (isset($interestData['id']) && !empty($interestData['id'])) {
                        // Update existing
                        StudentInterest::where('id', $interestData['id'])->update([
                            'job_role' => $interestData['job_role'],
                        ]);
                    } else {
                        // Create new
                        $student->interests()->create([
                            'job_role' => $interestData['job_role'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Show the import form
     */
    public function import()
    {
        return view('students.import');
    }

    /**
     * Process the Excel import
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('excel_file');
            $extension = $file->getClientOriginalExtension();
            
            // Read the file
            if ($extension === 'csv') {
                $data = $this->readCSV($file);
            } else {
                $data = $this->readExcelSimple($file);
            }

            // Process the data
            $summary = $this->importStudentData(
                $data,
                $request->boolean('skip_duplicates', true),
                $request->boolean('create_companies', true)
            );

            return redirect()->route('students.import')
                ->with('success', 'Import completed successfully!')
                ->with('import_summary', $summary);

        } catch (\Exception $e) {
            return redirect()->route('students.import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Read CSV file
     */
    private function readCSV($file)
    {
        $data = [];
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header row
        $headers = fgetcsv($handle);
        
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        
        fclose($handle);
        return $data;
    }

    /**
     * Read Excel file using simple XML parsing for XLSX
     */
    private function readExcelSimple($file)
    {
        try {
            $xlsx = new \Shuchkin\SimpleXLSX($file->getRealPath());
            
            if ($xlsx) {
                $rows = $xlsx->rows();
                array_shift($rows); // Remove header
                return $rows;
            }
        } catch (\Exception $e) {
            // Fallback: Ask user to convert to CSV
            throw new \Exception('Please save your Excel file as CSV format and try again. Error: ' . $e->getMessage());
        }
        
        return [];
    }

    /**
     * Import student data from parsed Excel rows
     */
    private function importStudentData($data, $skipDuplicates, $createCompanies)
    {
        $imported = 0;
        $skipped = 0;
        $companiesCreated = 0;

        DB::beginTransaction();
        
        try {
            foreach ($data as $row) {
                // Skip empty rows
                if (empty($row[0]) || empty($row[2])) {
                    continue;
                }

                $name = $row[0]; // Name of Student
                $batch = $row[1]; // Batch
                $cbNumber = $row[2]; // CB Number
                $semester = $row[3]; // Semester
                $vacancyName = $row[4]; // Vacancy
                $companiesApplied = $row[5]; // Companies Applied (comma-separated)
                $statusRaw = $row[6] ?? 'Applied'; // Status

                // Map status to valid enum values
                $statusMap = [
                    'Applied' => 'CV Sent',
                    'Pending' => 'Pending',
                    'CV Sent' => 'CV Sent',
                    'Shortlisted' => 'Shortlisted',
                    'Interview' => 'Interview',
                    'Rejected' => 'Rejected',
                    'Approved' => 'Approved',
                ];
                $status = $statusMap[$statusRaw] ?? 'Pending';

                // Check if student already exists
                if ($skipDuplicates && Student::where('student_id', $cbNumber)->exists()) {
                    $skipped++;
                    continue;
                }

                // Create or find student
                $student = Student::updateOrCreate(
                    ['student_id' => $cbNumber],
                    [
                        'name' => $name,
                        'batch' => $batch,
                        'semester' => $semester,
                        'email' => strtolower(str_replace(' ', '.', $cbNumber)) . '@example.com', // Generate email
                        'phone_number' => '0000000000', // Placeholder
                        'programme' => 'SE', // Default programme
                    ]
                );

                // Parse companies (comma-separated)
                $companyNames = array_map('trim', explode(',', $companiesApplied));
                
                foreach ($companyNames as $companyName) {
                    if (empty($companyName)) {
                        continue;
                    }

                    // Create or find company
                    $company = Company::where('name', $companyName)->first();
                    
                    if (!$company && $createCompanies) {
                        $company = Company::create([
                            'name' => $companyName,
                            'type' => 'IT',
                            'industry' => 'Technology',
                        ]);
                        $companiesCreated++;
                    }

                    if (!$company) {
                        continue; // Skip if company doesn't exist and auto-create is disabled
                    }

                    // Create application if it doesn't exist
                    Application::firstOrCreate(
                        [
                            'student_id' => $student->id,
                            'company_id' => $company->id,
                        ],
                        [
                            'vacancy_id' => null,
                            'status' => $status,
                            'applied_date' => now(),
                        ]
                    );
                }

                $imported++;
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'companies_created' => $companiesCreated,
        ];
    }
}
