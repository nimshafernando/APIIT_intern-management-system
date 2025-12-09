<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
            <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative transition-opacity duration-500" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <script>
                setTimeout(function() {
                    const message = document.getElementById('successMessage');
                    if(message) {
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.remove();
                        }, 500);
                    }
                }, 3000);
            </script>
            @endif

            <!-- Company Header Card with Large Logo -->
            <div class="bg-teal-50 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Large Company Logo -->
                        <div class="flex-shrink-0">
                            @php
                                $logoSrc = null;
                                if($application->company->logo) {
                                    $logoSrc = asset('storage/' . $application->company->logo);
                                } elseif($application->company->logo_url) {
                                    $logoSrc = $application->company->logo_url;
                                }
                            @endphp
                            @if($logoSrc)
                                <img src="{{ $logoSrc }}" alt="{{ $application->company->name }}" class="h-32 w-32 rounded-2xl object-cover shadow-lg ring-4 ring-white" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-32 w-32 rounded-2xl bg-teal-500 flex items-center justify-center shadow-lg ring-4 ring-white\'><span class=\'text-white text-4xl font-bold\'>{{ substr($application->company->name, 0, 2) }}</span></div>';">
                            @else
                                <div class="h-32 w-32 rounded-2xl bg-teal-500 flex items-center justify-center shadow-lg ring-4 ring-white">
                                    <span class="text-white text-4xl font-bold">{{ substr($application->company->name, 0, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Company Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $application->company->name }}</h1>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-gray-600 mb-4">
                                @if($application->company->industry)
                                <span class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ $application->company->industry }}
                                </span>
                                @endif
                                @if($application->company->location)
                                <span class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $application->company->location }}
                                </span>
                                @endif
                            </div>
                            @if($application->company->description)
                            <p class="text-gray-600 leading-relaxed">{{ Str::limit($application->company->description, 200) }}</p>
                            @endif
                        </div>

                        <!-- Current Status Badge -->
                        <div class="flex-shrink-0">
                            <span class="px-6 py-3 inline-flex text-lg leading-5 font-bold rounded-xl shadow-md
                                {{ $application->status == 'Approved' ? 'bg-green-100 text-green-800 ring-2 ring-green-200' : '' }}
                                {{ $application->status == 'Rejected' ? 'bg-red-100 text-red-800 ring-2 ring-red-200' : '' }}
                                {{ $application->status == 'Pending' ? 'bg-gray-100 text-gray-800 ring-2 ring-gray-200' : '' }}
                                {{ $application->status == 'CV Sent' ? 'bg-blue-100 text-blue-800 ring-2 ring-blue-200' : '' }}
                                {{ $application->status == 'Shortlisted' ? 'bg-yellow-100 text-yellow-800 ring-2 ring-yellow-200' : '' }}
                                {{ $application->status == 'Interview' ? 'bg-purple-100 text-purple-800 ring-2 ring-purple-200' : '' }}">
                                {{ $application->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Student Information -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Student Information
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Student Name</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $application->student->name }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">CB Number</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $application->student->student_id }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Programme</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $application->student->programme }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Email</p>
                                    <a href="mailto:{{ $application->student->email }}" class="text-lg font-bold text-teal-600 hover:underline">{{ $application->student->email }}</a>
                                </div>

                                @if($application->position)
                                <div class="bg-teal-50 p-4 rounded-lg border-2 border-teal-200">
                                    <p class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Position Applied For</p>
                                    <p class="text-lg font-bold text-teal-900">{{ $application->position }}</p>
                                </div>
                                @endif

                                @if($application->student->phone)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Phone</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $application->student->phone }}</p>
                                </div>
                                @endif

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Student Profile</p>
                                    <a href="{{ route('students.show', $application->student) }}" class="text-lg font-bold text-teal-600 hover:underline flex items-center gap-1">
                                        View Full Profile
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CV & Notes -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Application Documents
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- CV Download -->
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Submitted CV</p>
                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-teal-500 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-teal-600 shadow-md transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download CV (PDF)
                                </a>
                            </div>

                            <!-- Notes -->
                            @if($application->notes)
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Cover Letter / Notes</p>
                                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $application->notes }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Remarks Section -->
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Industry Liaison Remarks</p>
                                
                                <form method="POST" action="{{ route('applications.update', $application) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <textarea name="remarks" rows="4" class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" placeholder="Add remarks or notes about this application...">{{ old('remarks', $application->remarks) }}</textarea>
                                    
                                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Last updated: {{ $application->updated_at->format('M j, Y g:i A') }}
                                    </p>
                                    
                                    <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-lg font-semibold text-xs text-white tracking-wide hover:bg-teal-600 shadow-sm transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Save Remarks
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status & Timeline -->
                <div class="space-y-6">
                    <!-- Update Status Section -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Update Status
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('applications.update', $application) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Application Status</label>
                                        <select id="status" name="status" class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">
                                            <option value="Pending" {{ $application->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="CV Sent" {{ $application->status == 'CV Sent' ? 'selected' : '' }}>CV Sent</option>
                                            <option value="Shortlisted" {{ $application->status == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                            <option value="Interview" {{ $application->status == 'Interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="Approved" {{ $application->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-teal-500 border border-transparent rounded-lg font-bold text-sm text-white tracking-wide hover:bg-teal-600 shadow-md transition-all">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Application Timeline -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Timeline
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Application Submitted</p>
                                        <p class="text-xs text-gray-500">{{ $application->created_at->format('M j, Y g:i A') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $application->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                @if($application->sent_date)
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">CV Sent to Company</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($application->sent_date)->format('M j, Y g:i A') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($application->sent_date)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">Last Status Update</p>
                                        <p class="text-xs text-gray-500">{{ $application->updated_at->format('M j, Y g:i A') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $application->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                @php
                                    $submittedDate = $application->sent_date ?? $application->created_at;
                                    $daysActive = $submittedDate ? (int) $submittedDate->diffInDays(now()) : 0;
                                @endphp

                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="bg-teal-50 rounded-lg p-4">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Days Active</p>
                                        <p class="text-3xl font-bold text-teal-600">{{ $daysActive }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Since submission</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
