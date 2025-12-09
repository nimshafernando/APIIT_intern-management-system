<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log New Activity') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Log New Activity</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('activity-documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Activity Type -->
                            <div class="md:col-span-2">
                                <x-input-label for="activity_type_id" :value="__('Activity Type')" />
                                <select id="activity_type_id" name="activity_type_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Activity Type</option>
                                    @foreach($activityTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('activity_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('activity_type_id')" class="mt-2" />
                            </div>

                            <!-- Activity Date -->
                            <div>
                                <x-input-label for="activity_date" :value="__('Activity Date')" />
                                <x-text-input id="activity_date" class="block mt-1 w-full" type="date" name="activity_date" :value="old('activity_date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('activity_date')" class="mt-2" />
                            </div>

                            <!-- Recorded By (Hidden - current user) -->
                            <input type="hidden" name="recorded_by" value="{{ auth()->id() }}" />

                            <!-- Student (Optional) -->
                            <div>
                                <x-input-label for="student_id" :value="__('Related Student (Optional)')" />
                                <select id="student_id" name="student_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">None</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
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
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Activity Description')" />
                                <textarea id="description" name="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required placeholder="Describe the activity details, outcomes, and follow-up actions...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- File Upload (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="file_path" :value="__('Attach Document (Optional)')" />
                                <input id="file_path" type="file" name="file_path" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" />
                                <p class="mt-1 text-sm text-gray-500">Optional. Accepted formats: PDF, DOC, DOCX, JPG, PNG. Maximum size: 10MB.</p>
                                <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                            </div>

                            <!-- Notes (Optional) -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Additional Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" placeholder="Any additional notes or comments...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('activity-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Log Activity') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
