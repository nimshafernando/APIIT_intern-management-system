<x-app-layout>
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-3xl font-bold">{{ $student->name }}</h3>
            <p class="text-teal-50 text-lg mt-2">CB Number: {{ $student->student_id }}</p>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Student Information Card - Inline Editable -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Student Information</h3>
                        <div class="flex space-x-2">
                            <button type="button" id="toggleEditMode" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                                Edit Information
                            </button>
                            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" id="studentForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- CB Number -->
                            <div>
                                <x-input-label for="student_id" value="CB Number" />
                                <p class="mt-1 text-sm text-gray-900 font-medium edit-mode-hidden">{{ $student->student_id }}</p>
                                <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full edit-mode-visible hidden" :value="old('student_id', $student->student_id)" required />
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <!-- Full Name -->
                            <div>
                                <x-input-label for="name" value="Full Name" />
                                <p class="mt-1 text-sm text-gray-900 font-medium edit-mode-hidden">{{ $student->name }}</p>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full edit-mode-visible hidden" :value="old('name', $student->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="Email" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->email }}</p>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full edit-mode-visible hidden" :value="old('email', $student->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone_number" value="Phone Number" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->phone_number }}</p>
                                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full edit-mode-visible hidden" :value="old('phone_number', $student->phone_number)" required />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <x-input-label for="date_of_birth" value="Date of Birth" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->date_of_birth?->format('M j, Y') ?? 'Not set' }}</p>
                                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full edit-mode-visible hidden" :value="old('date_of_birth', $student->date_of_birth?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <!-- Profile Photo -->
                            <div>
                                <x-input-label for="profile_photo" value="Profile Photo" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->profile_photo ? 'Photo uploaded' : 'No photo uploaded' }}</p>
                                <div class="edit-mode-visible hidden">
                                    <input id="profile_photo" name="profile_photo" type="file" accept="image/jpeg,image/png" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max 2MB)</p>
                                </div>
                                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                            </div>

                            <!-- Programme -->
                            <div>
                                <x-input-label for="programme" value="Programme" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">
                                    @if($student->programme == 'SE') Software Engineering (SE)
                                    @elseif($student->programme == 'CS') Computer Science (CS)
                                    @elseif($student->programme == 'CT') Computing (CT)
                                    @else {{ $student->programme }}
                                    @endif
                                </p>
                                <select id="programme" name="programme" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full edit-mode-visible hidden" required>
                                    <option value="SE" {{ old('programme', $student->programme) == 'SE' ? 'selected' : '' }}>Software Engineering (SE)</option>
                                    <option value="CS" {{ old('programme', $student->programme) == 'CS' ? 'selected' : '' }}>Computer Science (CS)</option>
                                    <option value="CT" {{ old('programme', $student->programme) == 'CT' ? 'selected' : '' }}>Computing (CT)</option>
                                </select>
                                <x-input-error :messages="$errors->get('programme')" class="mt-2" />
                            </div>

                            <!-- Batch -->
                            <div>
                                <x-input-label for="batch" value="Batch" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->batch }}</p>
                                <x-text-input id="batch" name="batch" type="text" class="mt-1 block w-full edit-mode-visible hidden" :value="old('batch', $student->batch)" placeholder="e.g., 23.2" required />
                                <x-input-error :messages="$errors->get('batch')" class="mt-2" />
                            </div>

                            <!-- Semester -->
                            <div>
                                <x-input-label for="semester" value="Semester" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">Semester {{ $student->semester }}</p>
                                <select id="semester" name="semester" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full edit-mode-visible hidden" required>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $student->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>

                            <!-- Cumulative Marks -->
                            <div>
                                <x-input-label for="cumulative_marks" value="Cumulative Marks (1-100%)" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden">{{ $student->cumulative_marks ? number_format($student->cumulative_marks, 2) . '%' : 'Not set' }}</p>
                                <x-text-input id="cumulative_marks" name="cumulative_marks" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full edit-mode-visible hidden" :value="old('cumulative_marks', $student->cumulative_marks)" placeholder="e.g., 75.5" />
                                <x-input-error :messages="$errors->get('cumulative_marks')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" value="Notes / Additional Information" />
                                <p class="mt-1 text-sm text-gray-900 edit-mode-hidden whitespace-pre-wrap">{{ $student->notes ?? 'No additional notes' }}</p>
                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full edit-mode-visible hidden" placeholder="Any additional notes about the student...">{{ old('notes', $student->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Save/Cancel Buttons (shown in edit mode) -->
                        <div class="flex space-x-4 mt-6 edit-mode-visible hidden">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Save Changes
                            </button>
                            <button type="button" id="cancelEdit" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Internship Interests - Inline Editable -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Job Interests</h3>
                        <button type="button" id="toggleInterestsEdit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                            Edit Interests
                        </button>
                    </div>

                    <!-- View Mode -->
                    <div id="interestsViewMode">
                        @if($student->interests->count() > 0)
                            <div class="space-y-3">
                                @foreach($student->interests as $interest)
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="font-medium text-gray-900">{{ $interest->job_role }}</p>
                                        @if($interest->description)
                                            <p class="text-sm text-gray-600 mt-1">{{ $interest->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No interests specified</p>
                        @endif
                    </div>

                    <!-- Edit Mode -->
                    <form action="{{ route('students.update', $student) }}" method="POST" id="interestsForm" class="hidden">
                        @csrf
                        @method('PUT')

                        <div id="interestsContainer" class="space-y-3">
                            @forelse($student->interests as $index => $interest)
                                <div class="interest-item flex space-x-3">
                                    <div class="flex-1">
                                        <x-text-input name="interests[{{ $index }}][job_role]" type="text" class="block w-full" :value="$interest->job_role" placeholder="e.g., Web Developer, Data Analyst" />
                                        <input type="hidden" name="interests[{{ $index }}][id]" value="{{ $interest->id }}">
                                    </div>
                                    <button type="button" class="remove-interest px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                        Remove
                                    </button>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <button type="button" id="addInterest" class="mt-4 px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 text-sm">
                            + Add Interest
                        </button>

                        <div class="flex space-x-4 mt-6">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Save Interests
                            </button>
                            <button type="button" id="cancelInterestsEdit" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Applications</h3>
                        <a href="{{ route('applications.create', ['student_id' => $student->id]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            + Add Application
                        </a>
                    </div>
                    
                    @if($student->applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">CV</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($student->applications as $application)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                <div class="flex items-center space-x-3">
                                                    @php
                                                        $logoSrc = null;
                                                        // Try uploaded logo first
                                                        if($application->company->logo) {
                                                            $logoSrc = asset('storage/' . $application->company->logo);
                                                        }
                                                        // Fallback to Clearbit API logo
                                                        elseif($application->company->logo_url) {
                                                            $logoSrc = $application->company->logo_url;
                                                        }
                                                    @endphp
                                                    
                                                    @if($logoSrc)
                                                        <img src="{{ $logoSrc }}" alt="{{ $application->company->name }}" class="h-10 w-10 rounded object-cover" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-10 w-10 rounded bg-gradient-to-r from-teal-400 to-cyan-600 flex items-center justify-center\'><span class=\'text-white font-bold text-sm\'>{{ substr($application->company->name, 0, 2) }}</span></div>';">
                                                    @else
                                                        <div class="h-10 w-10 rounded bg-gradient-to-r from-teal-400 to-cyan-600 flex items-center justify-center">
                                                            <span class="text-white font-bold text-sm">{{ substr($application->company->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <span class="font-medium">{{ $application->company->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $application->position ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if($application->status === 'Approved') bg-green-100 text-green-800
                                                    @elseif($application->status === 'Rejected') bg-red-100 text-red-800
                                                    @elseif($application->status === 'Shortlisted') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $application->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $application->sent_date ? $application->sent_date->format('M j, Y') : 'Not set' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                @if($application->cv_file_path)
                                                    <a href="{{ Storage::url($application->cv_file_path) }}" target="_blank" class="inline-flex items-center text-teal-600 hover:text-teal-800">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        View
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-xs">No CV</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <a href="{{ route('applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No applications yet</p>
                    @endif
                </div>
            </div>

            <!-- Application Status Timeline -->
            @if($student->applications->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Application Status Timeline & Statistics</h3>
                    <div class="space-y-8">
                        @foreach($student->applications as $application)
                            @php
                                $statuses = ['Pending', 'CV Sent', 'Shortlisted', 'Interview', 'Approved'];
                                $currentStatus = $application->status;
                                $currentIndex = array_search($currentStatus, $statuses);
                                
                                // Handle Rejected status
                                if($currentStatus === 'Rejected') {
                                    $currentIndex = -1;
                                    $isRejected = true;
                                } else {
                                    $currentIndex = $currentIndex !== false ? $currentIndex : 0;
                                    $isRejected = false;
                                }
                                
                                $progressPercentage = $currentIndex >= 0 ? (($currentIndex + 1) / count($statuses)) * 100 : 0;
                                
                                // Calculate statistics
                                $submittedDate = $application->sent_date ?? $application->created_at;
                                $daysActive = $submittedDate ? (int) $submittedDate->diffInDays(now()) : 0;
                                $updatedDate = $application->updated_at;
                                $daysInCurrentStatus = $updatedDate ? (int) $updatedDate->diffInDays(now()) : 0;
                            @endphp
                            
                            <div class="border border-gray-200 rounded-lg p-6 bg-gradient-to-br from-gray-50 to-white">
                                <!-- Company Header with Logo -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-4">
                                        @php
                                            $logoSrc = null;
                                            if($application->company->logo) {
                                                $logoSrc = asset('storage/' . $application->company->logo);
                                            } elseif($application->company->logo_url) {
                                                $logoSrc = $application->company->logo_url;
                                            }
                                        @endphp
                                        @if($logoSrc)
                                            <img src="{{ $logoSrc }}" alt="{{ $application->company->name }}" class="h-12 w-12 rounded-lg object-cover shadow-md" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-12 w-12 rounded-lg bg-gradient-to-r from-teal-400 to-cyan-600 flex items-center justify-center shadow-md\'><span class=\'text-white font-bold\'>{{ substr($application->company->name, 0, 2) }}</span></div>';">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-teal-400 to-cyan-600 flex items-center justify-center shadow-md">
                                                <span class="text-white font-bold">{{ substr($application->company->name, 0, 2) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900">{{ $application->company->name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                <span class="font-medium">Submitted:</span> {{ $submittedDate ? $submittedDate->format('M j, Y') : 'Date not set' }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-4 py-2 text-sm rounded-lg font-bold shadow-sm
                                        @if($application->status === 'Approved') bg-green-100 text-green-800
                                        @elseif($application->status === 'Rejected') bg-red-100 text-red-800
                                        @elseif($application->status === 'Shortlisted' || $application->status === 'Interview') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $application->status }}
                                    </span>
                                </div>

                                <!-- Statistics Cards -->
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Total Days</p>
                                                <p class="text-2xl font-bold text-teal-600">{{ $daysActive }}</p>
                                            </div>
                                            <div class="h-12 w-12 bg-teal-100 rounded-full flex items-center justify-center">
                                                <svg class="h-6 w-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Since submission</p>
                                    </div>

                                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Current Stage</p>
                                                <p class="text-2xl font-bold text-blue-600">{{ $daysInCurrentStatus }}</p>
                                            </div>
                                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Days in {{ $application->status }}</p>
                                    </div>

                                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Progress</p>
                                                <p class="text-2xl font-bold text-purple-600">{{ $isRejected ? '0' : round($progressPercentage) }}%</p>
                                            </div>
                                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Through pipeline</p>
                                    </div>
                                </div>

                                <!-- Horizontal Timeline -->
                                <div class="bg-white rounded-lg p-6 border border-gray-200">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Application Journey</h5>
                                    
                                    <div class="relative">
                                        <!-- Timeline Container -->
                                        <div class="flex items-start justify-between">
                                            @foreach($statuses as $index => $status)
                                                <div class="flex flex-col items-center relative" style="flex: 1;">
                                                    <!-- Timeline Node -->
                                                    <div class="relative z-10 mb-3">
                                                        @if($isRejected)
                                                            <div class="w-10 h-10 rounded-full border-3 border-gray-300 bg-gray-100 flex items-center justify-center">
                                                                <span class="text-sm font-semibold text-gray-400">{{ $index + 1 }}</span>
                                                            </div>
                                                        @elseif($index < $currentIndex)
                                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </div>
                                                        @elseif($index === $currentIndex)
                                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-teal-400 to-cyan-600 flex items-center justify-center shadow-lg animate-pulse">
                                                                <span class="text-sm font-bold text-white">{{ $index + 1 }}</span>
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 rounded-full border-3 border-gray-300 bg-white flex items-center justify-center shadow-sm">
                                                                <span class="text-sm font-semibold text-gray-400">{{ $index + 1 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Status Label -->
                                                    <div class="text-center">
                                                        <p class="text-xs font-semibold mb-1 {{ $index === $currentIndex ? 'text-teal-600' : 'text-gray-600' }}">
                                                            {{ $status }}
                                                        </p>
                                                        @if($index === $currentIndex && !$isRejected)
                                                            <p class="text-xs text-gray-500">
                                                                {{ $updatedDate->format('M j, Y') }}
                                                            </p>
                                                        @elseif($index === 0)
                                                            <p class="text-xs text-gray-500">
                                                                {{ $submittedDate ? $submittedDate->format('M j, Y') : '-' }}
                                                            </p>
                                                        @else
                                                            <p class="text-xs text-gray-400">-</p>
                                                        @endif
                                                    </div>

                                                    <!-- Connecting Line -->
                                                    @if($index < count($statuses) - 1)
                                                        <div class="absolute top-5 left-1/2 w-full h-0.5" style="transform: translateY(-50%);">
                                                            @if(!$isRejected && $index < $currentIndex)
                                                                <div class="h-full bg-gradient-to-r from-green-500 to-green-600"></div>
                                                            @elseif(!$isRejected && $index === $currentIndex)
                                                                <div class="h-full bg-gradient-to-r from-teal-500 to-gray-300"></div>
                                                            @else
                                                                <div class="h-full bg-gray-300"></div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Rejected Status (if applicable) -->
                                    @if($isRejected)
                                        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="h-10 w-10 bg-red-500 rounded-full flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-red-800">Application Rejected</p>
                                                    <p class="text-xs text-red-600">{{ $updatedDate->format('M j, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Remarks -->
                                    @if($application->remarks)
                                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                            <p class="text-xs font-semibold text-blue-800 mb-1">Notes</p>
                                            <p class="text-sm text-blue-900">{{ $application->remarks }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Required Documents Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Required Documents</h3>
                    <div class="space-y-3">
                        @php
                            $requiredDocuments = ['CV', 'Activity Logs', 'Marksheets', 'Placement Forms'];
                            $uploadedDocs = $student->documents->pluck('documentType.name')->toArray();
                        @endphp

                        @foreach($requiredDocuments as $docName)
                            @php
                                $document = $student->documents->firstWhere('documentType.name', $docName);
                                $isUploaded = in_array($docName, $uploadedDocs);
                            @endphp
                            
                            <div class="flex items-center justify-between p-4 border-2 {{ $isUploaded ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }} rounded-lg">
                                <div class="flex items-center space-x-3 flex-1">
                                    <div class="flex-shrink-0">
                                        @if($isUploaded)
                                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $docName }}</p>
                                        @if($isUploaded && $document)
                                            <p class="text-sm text-gray-600">Uploaded {{ $document->created_at->diffForHumans() }}</p>
                                        @else
                                            <p class="text-sm text-red-600 font-medium">Missing - Awaiting student upload</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    @if($isUploaded && $document)
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                                            @if($document->status === 'Verified') bg-green-100 text-green-800
                                            @elseif($document->status === 'Rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ $document->status }}
                                        </span>
                                        @if($document->file_path)
                                            <a href="{{ route('student-documents.download', $document) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                            Missing
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Upload Progress -->
                    <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                        @php
                            $uploadedCount = count(array_intersect($requiredDocuments, $uploadedDocs));
                            $totalCount = count($requiredDocuments);
                            $percentage = $totalCount > 0 ? ($uploadedCount / $totalCount) * 100 : 0;
                        @endphp
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Document Completion</span>
                            <span class="text-sm font-bold text-gray-900">{{ $uploadedCount }}/{{ $totalCount }} ({{ round($percentage) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-300 rounded-full h-3">
                            <div class="bg-gradient-to-r from-teal-400 to-cyan-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Analytics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Student Analytics</h3>
                    
                    @php
                        $totalApplications = $student->applications->count();
                        $approvedApplications = $student->applications->where('status', 'Approved')->count();
                        $shortlistedApplications = $student->applications->where('status', 'Shortlisted')->count();
                        $interviewApplications = $student->applications->where('status', 'Interview')->count();
                        $rejectedApplications = $student->applications->where('status', 'Rejected')->count();
                        $pendingApplications = $student->applications->whereIn('status', ['Pending', 'CV Sent'])->count();
                        
                        $documentsUploaded = $student->documents->count();
                        $verifiedDocuments = $student->documents->where('status', 'Verified')->count();
                        $rejectedDocuments = $student->documents->where('status', 'Rejected')->count();
                        
                        $companiesApplied = $student->applications->pluck('company_id')->unique()->count();
                        $interestsCount = $student->interests->count();
                        
                        $applicationSuccessRate = $totalApplications > 0 ? ($approvedApplications / $totalApplications) * 100 : 0;
                        $documentVerificationRate = $documentsUploaded > 0 ? ($verifiedDocuments / $documentsUploaded) * 100 : 0;
                    @endphp

                    <!-- Key Metrics Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <!-- Total Applications -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-blue-600 font-medium uppercase">Total Applications</p>
                                    <p class="text-2xl font-bold text-blue-900 mt-1">{{ $totalApplications }}</p>
                                </div>
                                <svg class="h-10 w-10 text-blue-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Companies Applied -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-purple-600 font-medium uppercase">Companies</p>
                                    <p class="text-2xl font-bold text-purple-900 mt-1">{{ $companiesApplied }}</p>
                                </div>
                                <svg class="h-10 w-10 text-purple-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Approved Applications -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-green-600 font-medium uppercase">Approved</p>
                                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $approvedApplications }}</p>
                                </div>
                                <svg class="h-10 w-10 text-green-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Documents Verified -->
                        <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-4 rounded-lg border border-teal-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-teal-600 font-medium uppercase">Verified Docs</p>
                                    <p class="text-2xl font-bold text-teal-900 mt-1">{{ $verifiedDocuments }}/{{ $documentsUploaded }}</p>
                                </div>
                                <svg class="h-10 w-10 text-teal-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Application Status Breakdown -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Application Status Chart -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4">Application Status Breakdown</h4>
                            <div class="space-y-3">
                                <!-- Approved -->
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Approved</span>
                                        <span class="text-green-600 font-bold">{{ $approvedApplications }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $totalApplications > 0 ? ($approvedApplications / $totalApplications) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <!-- Shortlisted -->
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Shortlisted</span>
                                        <span class="text-blue-600 font-bold">{{ $shortlistedApplications }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $totalApplications > 0 ? ($shortlistedApplications / $totalApplications) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <!-- Interview -->
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Interview Stage</span>
                                        <span class="text-purple-600 font-bold">{{ $interviewApplications }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $totalApplications > 0 ? ($interviewApplications / $totalApplications) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <!-- Pending -->
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Pending/CV Sent</span>
                                        <span class="text-yellow-600 font-bold">{{ $pendingApplications }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $totalApplications > 0 ? ($pendingApplications / $totalApplications) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <!-- Rejected -->
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Rejected</span>
                                        <span class="text-red-600 font-bold">{{ $rejectedApplications }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $totalApplications > 0 ? ($rejectedApplications / $totalApplications) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4">Performance Metrics</h4>
                            <div class="space-y-4">
                                <!-- Success Rate -->
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-green-100 rounded-lg">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Success Rate</p>
                                            <p class="text-sm text-gray-900 font-semibold">{{ number_format($applicationSuccessRate, 1) }}%</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500">{{ $approvedApplications }}/{{ $totalApplications }} approved</span>
                                    </div>
                                </div>

                                <!-- Document Verification -->
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Doc Verification</p>
                                            <p class="text-sm text-gray-900 font-semibold">{{ number_format($documentVerificationRate, 1) }}%</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500">{{ $verifiedDocuments }}/{{ $documentsUploaded }} verified</span>
                                    </div>
                                </div>

                                <!-- Active Applications -->
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-purple-100 rounded-lg">
                                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Active Applications</p>
                                            <p class="text-sm text-gray-900 font-semibold">{{ $shortlistedApplications + $interviewApplications }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500">In progress</span>
                                    </div>
                                </div>

                                <!-- Job Interests -->
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-orange-100 rounded-lg">
                                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Job Interests</p>
                                            <p class="text-sm text-gray-900 font-semibold">{{ $interestsCount }} roles</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500">Specified</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Toggle edit mode for student information
        document.getElementById('toggleEditMode').addEventListener('click', function() {
            const hiddenElements = document.querySelectorAll('.edit-mode-hidden');
            const visibleElements = document.querySelectorAll('.edit-mode-visible');
            
            hiddenElements.forEach(el => el.classList.toggle('hidden'));
            visibleElements.forEach(el => el.classList.toggle('hidden'));
            
            this.textContent = this.textContent === 'Edit Information' ? 'View Mode' : 'Edit Information';
        });

        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('toggleEditMode').click();
        });

        // Toggle edit mode for interests
        document.getElementById('toggleInterestsEdit').addEventListener('click', function() {
            document.getElementById('interestsViewMode').classList.toggle('hidden');
            document.getElementById('interestsForm').classList.toggle('hidden');
            this.textContent = this.textContent === 'Edit Interests' ? 'View Mode' : 'Edit Interests';
        });

        document.getElementById('cancelInterestsEdit').addEventListener('click', function() {
            document.getElementById('toggleInterestsEdit').click();
        });

        // Add interest
        let interestIndex = {{ $student->interests->count() }};
        document.getElementById('addInterest').addEventListener('click', function() {
            const container = document.getElementById('interestsContainer');
            const newInterest = document.createElement('div');
            newInterest.className = 'interest-item flex space-x-3';
            newInterest.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="interests[${interestIndex}][job_role]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" placeholder="e.g., Web Developer, Data Analyst">
                </div>
                <button type="button" class="remove-interest px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                    Remove
                </button>
            `;
            container.appendChild(newInterest);
            interestIndex++;
        });

        // Remove interest
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-interest')) {
                e.target.closest('.interest-item').remove();
            }
        });
    </script>
</x-app-layout>
