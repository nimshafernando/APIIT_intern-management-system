<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Apply Students to Opportunity') }}
            </h2>
            <a href="{{ route('opportunities.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Opportunities
            </a>
        </div>
    </x-slot>

    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Apply Students to {{ $opportunity->company->name }}</h3>
            @if(!empty($opportunity->roles))
                <p class="mt-2 text-sm">Available Roles: {{ implode(', ', $opportunity->roles) }}</p>
            @endif
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <form action="{{ route('opportunities.store-applications', $opportunity) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Position Field -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Position/Role Details</h4>
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                                <input type="text" id="position" name="position" 
                                       value="{{ old('position', implode(', ', $opportunity->roles ?? [])) }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                       placeholder="e.g., Software Engineer Intern">
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Matching Students -->
                    @if($matchingStudents->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Students with Matching Interests ({{ $matchingStudents->count() }})
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">These students have interests that match the opportunity roles.</p>
                            
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="select-all-matching" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Select All Matching Students</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($matchingStudents as $student)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-teal-300 transition">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                               class="mt-1 rounded border-gray-300 text-teal-600 focus:ring-teal-500 matching-student">
                                        <div class="ml-3 flex-1">
                                            <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $student->student_id }}</div>
                                            <div class="text-sm text-gray-500">{{ $student->programme }}</div>
                                            @if($student->interests->count() > 0)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach($student->interests as $interest)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                              {{ in_array($interest->job_role, $opportunity->roles ?? []) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                            {{ $interest->job_role }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- All Students -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                All Students ({{ $allStudents->count() }})
                            </h4>
                            
                            <div class="mb-4 flex flex-wrap gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="select-all-students" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Select All Students</span>
                                </label>
                                <input type="text" id="search-students" placeholder="Search students..." 
                                       class="rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                <select id="filter-interests" class="rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">All Interests</option>
                                    @php
                                        $allInterests = $allStudents->flatMap(function($student) { 
                                            return $student->interests; 
                                        })->pluck('job_role')->unique()->sort();
                                    @endphp
                                    @foreach($allInterests as $interest)
                                        <option value="{{ $interest }}">{{ $interest }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto" id="all-students-list">
                                @foreach($allStudents as $student)
                                <div class="border border-gray-200 rounded p-4 hover:border-teal-300 transition student-item" 
                                     data-name="{{ strtolower($student->name) }}" 
                                     data-id="{{ strtolower($student->student_id) }}" 
                                     data-programme="{{ strtolower($student->programme) }}"
                                     data-interests="{{ strtolower($student->interests->pluck('job_role')->implode(' ')) }}">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                               class="mt-1 rounded border-gray-300 text-teal-600 focus:ring-teal-500 all-student">
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                            <div class="text-xs text-gray-600">{{ $student->student_id }}</div>
                                            <div class="text-xs text-gray-500 mb-2">{{ $student->programme }}</div>
                                            
                                            <!-- Student Interests -->
                                            @if($student->interests->count() > 0)
                                                <div class="mt-2">
                                                    <p class="text-xs text-gray-500 mb-1">Interests:</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach($student->interests as $interest)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                                      {{ in_array($interest->job_role, $opportunity->roles ?? []) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                                {{ $interest->job_role }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-xs text-gray-400 mt-2">No interests specified</p>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Apply Selected Students</h4>
                                    <p class="text-sm text-gray-600 mt-1">Selected students will have applications created for {{ $opportunity->company->name }}</p>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('opportunities.index') }}" 
                                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition disabled:opacity-50"
                                            id="submit-btn" disabled>
                                        Apply Students
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllMatching = document.getElementById('select-all-matching');
            const selectAllStudents = document.getElementById('select-all-students');
            const matchingCheckboxes = document.querySelectorAll('.matching-student');
            const allStudentCheckboxes = document.querySelectorAll('.all-student');
            const submitBtn = document.getElementById('submit-btn');
            const searchInput = document.getElementById('search-students');
            const interestFilter = document.getElementById('filter-interests');
            const studentItems = document.querySelectorAll('.student-item');

            // Select all matching students
            if (selectAllMatching) {
                selectAllMatching.addEventListener('change', function() {
                    matchingCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSubmitButton();
                });
            }

            // Select all students
            selectAllStudents.addEventListener('change', function() {
                allStudentCheckboxes.forEach(checkbox => {
                    if (checkbox.closest('.student-item').style.display !== 'none') {
                        checkbox.checked = this.checked;
                    }
                });
                updateSubmitButton();
            });

            // Update submit button state
            function updateSubmitButton() {
                const checkedBoxes = document.querySelectorAll('input[name="student_ids[]"]:checked');
                submitBtn.disabled = checkedBoxes.length === 0;
            }

            // Search and filter functionality
            function filterStudents() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedInterest = interestFilter.value.toLowerCase();

                studentItems.forEach(item => {
                    const name = item.dataset.name || '';
                    const id = item.dataset.id || '';
                    const programme = item.dataset.programme || '';
                    const interests = item.dataset.interests || '';

                    const matchesSearch = searchTerm === '' || 
                        name.includes(searchTerm) || 
                        id.includes(searchTerm) || 
                        programme.includes(searchTerm);

                    const matchesInterest = selectedInterest === '' || 
                        interests.includes(selectedInterest);

                    if (matchesSearch && matchesInterest) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                        // Uncheck hidden items
                        const checkbox = item.querySelector('input[type="checkbox"]');
                        if (checkbox && checkbox.checked) {
                            checkbox.checked = false;
                        }
                    }
                });

                updateSubmitButton();
            }

            // Listen to all checkboxes
            document.querySelectorAll('input[name="student_ids[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateSubmitButton);
            });

            // Add event listeners
            searchInput.addEventListener('input', filterStudents);
            if (interestFilter) {
                interestFilter.addEventListener('change', filterStudents);
            }
        });
    </script>
</x-app-layout>