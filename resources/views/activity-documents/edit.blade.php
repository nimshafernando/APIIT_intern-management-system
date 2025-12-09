<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activity') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Edit Activity</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('activity-documents.update', $activityDocument) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Activity Type -->
                            <div class="md:col-span-2">
                                <x-input-label for="activity_type_id" :value="__('Activity Type')" />
                                <select id="activity_type_id" name="activity_type_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Activity Type</option>
                                    @foreach($activityTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('activity_type_id', $activityDocument->activity_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('activity_type_id')" class="mt-2" />
                            </div>

                            <!-- Activity Date -->
                            <div>
                                <x-input-label for="activity_date" :value="__('Activity Date')" />
                                <x-text-input id="activity_date" class="block mt-1 w-full" type="date" name="activity_date" :value="old('activity_date', $activityDocument->activity_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('activity_date')" class="mt-2" />
                            </div>

                            <!-- Student (Optional) -->
                            <div>
                                <x-input-label for="student_id" :value="__('Related Student (Optional)')" />
                                <select id="student_id" name="student_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">None</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $activityDocument->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->cb_number }} - {{ $student->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <!-- Company (Optional) -->
                            <div>
                                <x-input-label for="company_id" :value="__('Related Company (Optional)')" />
                                <select id="company_id" name="company_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">None</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $activityDocument->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Activity Description')" />
                                <textarea id="description" name="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('description', $activityDocument->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Current File -->
                            @if($activityDocument->file_path)
                            <div class="md:col-span-2">
                                <x-input-label for="current_file" :value="__('Current Attachment')" />
                                <div class="mt-1">
                                    <a href="{{ route('activity-documents.download', $activityDocument) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ basename($activityDocument->file_path) }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Replace File (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="file_path" :value="__('Replace Attachment (Optional)')" />
                                <input id="file_path" type="file" name="file_path" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" />
                                <p class="mt-1 text-sm text-gray-500">Leave empty to keep the existing file. Accepted formats: PDF, DOC, DOCX, JPG, PNG. Maximum size: 10MB.</p>
                                <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                            </div>

                            <!-- Notes (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Additional Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('notes', $activityDocument->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('activity-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Activity') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
