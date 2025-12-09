<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('student-documents.download', $studentDocument) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Download
                </a>
                <a href="{{ route('student-documents.edit', $studentDocument) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit
                </a>
                <a href="{{ route('student-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Document Details</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            <!-- Document Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $studentDocument->documentType->name }}</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Uploaded on {{ $studentDocument->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div>
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $studentDocument->status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $studentDocument->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $studentDocument->status == 'Uploaded' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ $studentDocument->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student Name</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->student->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">CB Number</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->student->cb_number }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Programme</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->student->programme }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-gray-900">
                                <a href="mailto:{{ $studentDocument->student->email }}" class="text-indigo-600 hover:underline">{{ $studentDocument->student->email }}</a>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">View Student Profile</p>
                            <p class="mt-1">
                                <a href="{{ route('students.show', $studentDocument->student) }}" class="text-indigo-600 hover:underline">View Full Profile</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Document Type</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->documentType->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">File Name</p>
                            <p class="mt-1 text-gray-900">{{ basename($studentDocument->file_path) }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $studentDocument->status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $studentDocument->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $studentDocument->status == 'Uploaded' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ $studentDocument->status }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Uploaded By</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->uploadedBy->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Uploaded On</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Last Updated</p>
                            <p class="mt-1 text-gray-900">{{ $studentDocument->updated_at->format('F j, Y g:i A') }}</p>
                        </div>

                        @if($studentDocument->notes)
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 mb-2">Notes</p>
                            <div class="p-4 bg-gray-50 rounded-md">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $studentDocument->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Download Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Download Document</h3>
                    
                    <a href="{{ route('student-documents.download', $studentDocument) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download {{ basename($studentDocument->file_path) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
