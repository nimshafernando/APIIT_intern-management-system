<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student Document') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Edit Document</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('student-documents.update', $studentDocument) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student (Read-only) -->
                            <div class="md:col-span-2">
                                <x-input-label for="student_name" :value="__('Student')" />
                                <x-text-input id="student_name" class="block mt-1 w-full bg-gray-100" type="text" :value="$studentDocument->student->cb_number . ' - ' . $studentDocument->student->name" readonly />
                            </div>

                            <!-- Document Type -->
                            <div class="md:col-span-2">
                                <x-input-label for="document_type_id" :value="__('Document Type')" />
                                <select id="document_type_id" name="document_type_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Document Type</option>
                                    @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('document_type_id', $studentDocument->document_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('document_type_id')" class="mt-2" />
                            </div>

                            <!-- Current File -->
                            <div class="md:col-span-2">
                                <x-input-label for="current_file" :value="__('Current Document')" />
                                <div class="mt-1">
                                    <a href="{{ route('student-documents.download', $studentDocument) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ basename($studentDocument->file_path) }}
                                    </a>
                                </div>
                            </div>

                            <!-- Replace File (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="file_path" :value="__('Replace Document (Optional)')" />
                                <input id="file_path" type="file" name="file_path" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" />
                                <p class="mt-1 text-sm text-gray-500">Leave empty to keep the existing file. Accepted formats: PDF, DOC, DOCX, JPG, PNG. Maximum size: 10MB.</p>
                                <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="Uploaded" {{ old('status', $studentDocument->status) == 'Uploaded' ? 'selected' : '' }}>Uploaded</option>
                                    <option value="Verified" {{ old('status', $studentDocument->status) == 'Verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="Rejected" {{ old('status', $studentDocument->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Notes (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('notes', $studentDocument->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('student-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Document') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
