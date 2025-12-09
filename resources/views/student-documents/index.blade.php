<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Documents') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-6">
            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 mb-6">
                <div class="bg-teal-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search & Filter Student Documents
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('student-documents.index') }}" id="filterForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <!-- Search by CB Number -->
                            <div>
                                <label for="cb_number" class="block text-sm font-medium text-gray-700 mb-2">CB Number</label>
                                <input type="text" 
                                       id="cb_number" 
                                       name="cb_number" 
                                       value="{{ request('cb_number') }}"
                                       placeholder="Type CB number..."
                                       list="cb_numbers"
                                       class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">
                                <datalist id="cb_numbers">
                                    @foreach($students as $student)
                                        <option value="{{ $student->student_id }}">{{ $student->student_id }} - {{ $student->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            
                            <!-- Search by Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Student Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ request('name') }}"
                                       placeholder="Type student name..."
                                       list="student_names"
                                       class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">
                                <datalist id="student_names">
                                    @foreach($students as $student)
                                        <option value="{{ $student->name }}">{{ $student->name }} - {{ $student->student_id }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            
                            <!-- Filter by Programme -->
                            <div>
                                <label for="programme" class="block text-sm font-medium text-gray-700 mb-2">Programme</label>
                                <select id="programme" name="programme" class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">
                                    <option value="">All Programmes</option>
                                    @php
                                        $programmes = $students->pluck('programme')->unique()->sort()->values();
                                    @endphp
                                    @foreach($programmes as $prog)
                                        <option value="{{ $prog }}" {{ request('programme') == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Filter by Batch -->
                            <div>
                                <label for="batch" class="block text-sm font-medium text-gray-700 mb-2">Batch</label>
                                <select id="batch" name="batch" class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">
                                    <option value="">All Batches</option>
                                    @php
                                        $batches = $students->pluck('batch')->unique()->sort()->values();
                                    @endphp
                                    @foreach($batches as $bat)
                                        @if($bat)
                                            <option value="{{ $bat }}" {{ request('batch') == $bat ? 'selected' : '' }}>{{ $bat }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-teal-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-teal-600 shadow-md transition-all">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Search
                            </button>
                            <a href="{{ route('student-documents.index') }}" class="px-6 py-2 bg-gray-300 border border-transparent rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-400 shadow-md transition-all">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @php
                $filteredStudents = $students;
                
                // Apply CB number filter
                if(request('cb_number')) {
                    $cbNumber = strtolower(request('cb_number'));
                    $filteredStudents = $filteredStudents->filter(function($student) use ($cbNumber) {
                        return str_contains(strtolower($student->student_id), $cbNumber);
                    });
                }
                
                // Apply name filter
                if(request('name')) {
                    $nameSearch = strtolower(request('name'));
                    $filteredStudents = $filteredStudents->filter(function($student) use ($nameSearch) {
                        return str_contains(strtolower($student->name), $nameSearch);
                    });
                }
                
                // Apply programme filter
                if(request('programme')) {
                    $filteredStudents = $filteredStudents->where('programme', request('programme'));
                }
                
                // Apply batch filter
                if(request('batch')) {
                    $filteredStudents = $filteredStudents->where('batch', request('batch'));
                }
                
                $selectedStudent = request('student_id') ? $filteredStudents->firstWhere('id', request('student_id')) : null;
            @endphp

            @if(request()->hasAny(['cb_number', 'name', 'programme', 'batch']))
                <!-- Filtered Students List -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 mb-6">
                    <div class="bg-teal-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">
                            Search Results ({{ $filteredStudents->count() }} student{{ $filteredStudents->count() != 1 ? 's' : '' }} found)
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($filteredStudents->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($filteredStudents as $student)
                                <a href="{{ route('student-documents.index', ['student_id' => $student->id] + request()->except('student_id')) }}" 
                                   class="block p-4 border border-gray-200 rounded-lg hover:border-teal-500 hover:shadow-md transition-all {{ request('student_id') == $student->id ? 'bg-teal-50 border-teal-500' : 'bg-white' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-12 bg-teal-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white text-lg font-bold">{{ substr($student->name, 0, 2) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-600">{{ $student->student_id }}</p>
                                            <p class="text-xs text-teal-600 font-medium">{{ $student->programme }}</p>
                                            @if($student->batch)
                                                <p class="text-xs text-gray-500">Batch: {{ $student->batch }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No students found matching your criteria</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(request('student_id'))
                @php
                    $documentTypeNames = ['CVs', 'Activity Logs', 'Marksheets', 'Placement Forms'];
                @endphp

                @if($selectedStudent)
                <!-- Student Info Header -->
                <div class="bg-gradient-to-r from-teal-50 to-teal-100 overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-20 w-20 bg-teal-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-3xl font-bold">{{ substr($selectedStudent->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900">{{ $selectedStudent->name }}</h2>
                                    <p class="text-lg text-gray-600 mt-1">
                                        <span class="font-semibold">{{ $selectedStudent->student_id }}</span> | {{ $selectedStudent->programme }}
                                    </p>
                                    <div class="flex gap-4 mt-2 text-sm text-gray-600">
                                        @if($selectedStudent->batch)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Batch: {{ $selectedStudent->batch }}
                                            </span>
                                        @endif
                                        @if($selectedStudent->semester)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                                Semester: {{ $selectedStudent->semester }}
                                            </span>
                                        @endif
                                        @if($selectedStudent->email)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $selectedStudent->email }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('students.show', $selectedStudent) }}" class="px-4 py-2 bg-teal-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-teal-600 shadow-md transition-all">
                                View Full Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Documents Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($documentTypeNames as $typeName)
                        @php
                            $docType = $documentTypes->firstWhere('name', $typeName);
                            $studentDocs = $documents->where('document_type_id', $docType?->id ?? null);
                        @endphp
                        
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                            <div class="bg-teal-500 px-6 py-4">
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $typeName }}
                                </h3>
                            </div>
                            <div class="p-6">
                                @if($studentDocs->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($studentDocs as $doc)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-teal-300 transition-colors">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ basename($doc->file_path) }}</p>
                                                <p class="text-xs text-gray-500">{{ $doc->created_at->format('M j, Y') }}</p>
                                            </div>
                                            <a href="{{ route('student-documents.download', $doc) }}" class="ml-3 inline-flex items-center px-3 py-1 bg-teal-500 border border-transparent rounded-lg font-semibold text-xs text-white hover:bg-teal-600 shadow-sm transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Student hasn't uploaded {{ strtolower($typeName) }} yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Search for a student</h3>
                        <p class="mt-2 text-sm text-gray-500">Use the search and filter options above to find student documents</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
