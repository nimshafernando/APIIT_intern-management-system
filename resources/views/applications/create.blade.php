<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Application') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">
                @if(isset($opportunity))
                    Apply to {{ $opportunity->company->name }}
                @else
                    Track New Application
                @endif
            </h3>
            @if(isset($opportunity) && !empty($opportunity->roles))
                <p class="mt-2 text-sm">Roles: {{ implode(', ', $opportunity->roles) }}</p>
            @endif
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student -->
                            <div class="md:col-span-2">
                                <x-input-label for="student_id" :value="__('Student')" />
                                <select id="student_id" name="student_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                            data-cvs="{{ $student->documents()->whereHas('documentType', function($q) { $q->where('name', 'CVs'); })->get()->toJson() }}"
                                            {{ old('student_id', request('student_id')) == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_id }} - {{ $student->name }} ({{ $student->programme }})
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <!-- Company -->
                            <div class="md:col-span-2">
                                <x-input-label for="company_id" :value="__('Company')" />
                                <select id="company_id" name="company_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required {{ isset($preselectedCompanyId) ? 'readonly' : '' }}>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $preselectedCompanyId ?? '') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if(isset($opportunity))
                                    <p class="mt-1 text-sm text-gray-500">Company pre-selected from opportunity announcement</p>
                                @endif
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>

                            <!-- Position -->
                            <div class="md:col-span-2">
                                <x-input-label for="position" :value="__('Position / Role')" />
                                <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" placeholder="e.g., Software Engineer Intern, Data Analyst Intern" />
                                <p class="mt-1 text-sm text-gray-500">Enter the position or role you're applying for at this company.</p>
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>

                            <!-- Student's Uploaded CVs -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Student's Uploaded CVs</label>
                                
                                <div id="studentCVsSection" class="bg-teal-50 border border-teal-200 rounded-lg p-4">
                                    <div id="cvsContent" class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm text-teal-700 mt-2">Select a student to view their uploaded CVs</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual CV Upload -->
                            <div class="md:col-span-2">
                                <x-input-label for="cv_file" :value="__('Or Upload New CV (PDF)')" />
                                <input id="cv_file" type="file" name="cv_file" accept=".pdf,.doc,.docx" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" />
                                <p class="mt-1 text-sm text-gray-500">Maximum file size: 5MB. Accepted formats: PDF, DOC, DOCX.</p>
                                <x-input-error :messages="$errors->get('cv_file')" class="mt-2" />
                            </div>

                            <!-- Status (Hidden - default to Pending) -->
                            <input type="hidden" name="status" value="Pending" />

                            <!-- Applied By (Hidden - current user) -->
                            <input type="hidden" name="applied_by" value="{{ auth()->id() }}" />

                            <!-- Cover Letter / Additional Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Cover Letter / Additional Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Submit Application') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('student_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cvsData = selectedOption.getAttribute('data-cvs');
            const cvsContent = document.getElementById('cvsContent');
            
            if (this.value === '') {
                showEmptyState('Select a student to view their uploaded CVs');
                return;
            }
            
            if (cvsData && cvsData !== '[]') {
                const cvs = JSON.parse(cvsData);
                
                if (cvs.length > 0) {
                    let html = '<p class="text-sm text-teal-700 font-medium mb-3 text-left">Available CVs from student\'s profile:</p>';
                    html += '<div class="space-y-2">';
                    
                    cvs.forEach(cv => {
                        const fileName = cv.file_path.split('/').pop();
                        const uploadDate = new Date(cv.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        const fileUrl = '/storage/' + cv.file_path;
                        
                        html += `
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-teal-100">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">${fileName}</p>
                                        <p class="text-xs text-gray-500">Uploaded: ${uploadDate}</p>
                                    </div>
                                </div>
                                <a href="${fileUrl}" target="_blank" class="inline-flex items-center px-3 py-1 bg-teal-500 text-white text-xs font-semibold rounded-lg hover:bg-teal-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    cvsContent.innerHTML = html;
                } else {
                    showMissingState();
                }
            } else {
                showMissingState();
            }
        });

        function showMissingState() {
            const cvsContent = document.getElementById('cvsContent');
            cvsContent.innerHTML = `
                <div class="text-center py-4">
                    <svg class="mx-auto h-12 w-12 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm font-semibold text-red-700 mt-2">CV Missing</p>
                    <p class="text-xs text-red-600 mt-1">Student hasn't uploaded any CVs yet. Please upload manually below.</p>
                </div>
            `;
        }

        function showEmptyState(message) {
            const cvsContent = document.getElementById('cvsContent');
            cvsContent.innerHTML = `
                <div class="text-center py-4">
                    <svg class="mx-auto h-12 w-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-teal-700 mt-2">${message}</p>
                </div>
            `;
        }

        // Trigger on page load if student is already selected
        window.addEventListener('DOMContentLoaded', function() {
            const studentSelect = document.getElementById('student_id');
            if (studentSelect.value) {
                studentSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
