<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activity Details') }}
            </h2>
            <div class="flex gap-2">
                @if($activityDocument->file_path)
                <a href="{{ route('activity-documents.download', $activityDocument) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Download
                </a>
                @endif
                <a href="{{ route('activity-documents.edit', $activityDocument) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit
                </a>
                <a href="{{ route('activity-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Activity Details</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            <!-- Activity Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $activityDocument->activityType->name }}</h1>
                            <p class="mt-2 text-lg text-indigo-600">
                                {{ $activityDocument->activity_date->format('F j, Y') }}
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                Recorded on {{ $activityDocument->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Entities -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Information -->
                @if($activityDocument->student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Student</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Student Name</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->student->name }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">CB Number</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->student->cb_number }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Programme</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->student->programme }}</p>
                            </div>

                            <div>
                                <a href="{{ route('students.show', $activityDocument->student) }}" class="text-indigo-600 hover:underline">View Student Profile →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Company Information -->
                @if($activityDocument->company)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Company</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Company Name</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->company->name }}</p>
                            </div>

                            @if($activityDocument->company->type)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Company Type</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->company->type }}</p>
                            </div>
                            @endif

                            @if($activityDocument->company->contact_person)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact Person</p>
                                <p class="mt-1 text-gray-900">{{ $activityDocument->company->contact_person }}</p>
                            </div>
                            @endif

                            <div>
                                <a href="{{ route('companies.show', $activityDocument->company) }}" class="text-indigo-600 hover:underline">View Company Profile →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Activity Description -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Description</h3>
                    
                    <div class="p-4 bg-gray-50 rounded-md">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $activityDocument->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            @if($activityDocument->notes)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                    
                    <div class="p-4 bg-gray-50 rounded-md">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $activityDocument->notes }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Attachment -->
            @if($activityDocument->file_path)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Attachment</h3>
                    
                    <div class="flex items-center gap-4">
                        <a href="{{ route('activity-documents.download', $activityDocument) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download {{ basename($activityDocument->file_path) }}
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Activity Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Log Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Activity Type</p>
                            <p class="mt-1 text-gray-900">{{ $activityDocument->activityType->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Activity Date</p>
                            <p class="mt-1 text-gray-900">{{ $activityDocument->activity_date->format('F j, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Recorded By</p>
                            <p class="mt-1 text-gray-900">{{ $activityDocument->recordedBy->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Recorded On</p>
                            <p class="mt-1 text-gray-900">{{ $activityDocument->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Last Updated</p>
                            <p class="mt-1 text-gray-900">{{ $activityDocument->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
