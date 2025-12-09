<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Import Students') }}
            </h2>
            <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Students
            </a>
        </div>
    </x-slot>

    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Import Students from Excel</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-6 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Instructions Card -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Excel File Format Instructions</h3>
                        <p class="text-blue-700 mb-3">Your Excel file must contain the following columns in this exact order:</p>
                        <ul class="list-disc list-inside text-blue-700 space-y-1 mb-3">
                            <li><strong>Name of Student</strong> - Full name of the student</li>
                            <li><strong>Batch</strong> - Batch number (e.g., 24.1, 23.2)</li>
                            <li><strong>CB Number</strong> - Student ID number</li>
                            <li><strong>Semester</strong> - Current semester</li>
                            <li><strong>Vacancy</strong> - Position/vacancy name</li>
                            <li><strong>Companies Applied</strong> - All companies in one cell (comma-separated)</li>
                            <li><strong>Status</strong> - Application status (Pending, CV Sent, Shortlisted, Interview, Approved, Rejected, or Applied)</li>
                        </ul>
                        <p class="text-sm text-blue-600">
                            <strong>Note:</strong> The first row should contain column headers. Supported file types: .xlsx, .xls, .csv
                        </p>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('students.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- File Upload -->
                        <div class="mb-6">
                            <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Excel File
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-teal-500 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Excel or CSV files up to 10MB
                                    </p>
                                </div>
                            </div>
                            @error('excel_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
                        </div>

                        <!-- Import Options -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Import Options</h4>
                            
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="skip_duplicates" value="1" checked class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <span class="ml-2 text-sm text-gray-700">Skip duplicate students (based on CB Number)</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" name="create_companies" value="1" checked class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <span class="ml-2 text-sm text-gray-700">Automatically create companies if they don't exist</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" name="create_vacancies" value="1" checked class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <span class="ml-2 text-sm text-gray-700">Automatically create vacancies if they don't exist</span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 font-semibold">
                                Import Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Imports (if any) -->
            @if(session('import_summary'))
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Last Import Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-green-600 font-medium">Imported</p>
                            <p class="text-2xl font-bold text-green-900">{{ session('import_summary')['imported'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-600 font-medium">Skipped</p>
                            <p class="text-2xl font-bold text-blue-900">{{ session('import_summary')['skipped'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-sm text-yellow-600 font-medium">Companies Created</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ session('import_summary')['companies_created'] ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm text-purple-600 font-medium">Vacancies Created</p>
                            <p class="text-2xl font-bold text-purple-900">{{ session('import_summary')['vacancies_created'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Show selected filename
        document.getElementById('excel_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').textContent = '📄 Selected: ' + fileName;
            }
        });
    </script>
</x-app-layout>
