<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Edit Student</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('students.update', $student) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student ID (CB Number) -->
                            <div>
                                <x-input-label for="student_id" :value="__('Student ID (CB Number)')" />
                                <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id', $student->student_id)" required />
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $student->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $student->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $student->phone_number)" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth', $student->date_of_birth)" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <!-- Profile Photo -->
                            <div>
                                <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                                @if($student->profile_photo)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($student->profile_photo) }}" alt="Profile Photo" class="w-20 h-20 rounded-full object-cover">
                                        <p class="text-xs text-gray-500 mt-1">Current photo</p>
                                    </div>
                                @endif
                                <input id="profile_photo" type="file" name="profile_photo" accept="image/*"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" />
                                <p class="mt-1 text-xs text-gray-500">JPG, PNG (Max 2MB) - Leave empty to keep current photo</p>
                                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                            </div>

                            <!-- Programme -->
                            <div>
                                <x-input-label for="programme" :value="__('Programme')" />
                                <select id="programme" name="programme" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Select Programme</option>
                                    <option value="SE" {{ old('programme', $student->programme) == 'SE' ? 'selected' : '' }}>Software Engineering (SE)</option>
                                    <option value="CS" {{ old('programme', $student->programme) == 'CS' ? 'selected' : '' }}>Computer Science (CS)</option>
                                    <option value="CT" {{ old('programme', $student->programme) == 'CT' ? 'selected' : '' }}>Computer Technology (CT)</option>
                                </select>
                                <x-input-error :messages="$errors->get('programme')" class="mt-2" />
                            </div>

                            <!-- Batch -->
                            <div>
                                <x-input-label for="batch" :value="__('Batch')" />
                                <x-text-input id="batch" class="block mt-1 w-full" type="text" name="batch" :value="old('batch', $student->batch)" placeholder="e.g., 2023" />
                                <x-input-error :messages="$errors->get('batch')" class="mt-2" />
                            </div>

                            <!-- Semester -->
                            <div>
                                <x-input-label for="semester" :value="__('Semester')" />
                                <select id="semester" name="semester" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select Semester</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $student->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>

                            <!-- GPA -->
                            <div>
                                <x-input-label for="gpa" :value="__('GPA (0.00 - 4.00)')" />
                                <x-text-input id="gpa" class="block mt-1 w-full" type="number" name="gpa" :value="old('gpa', $student->gpa)" step="0.01" min="0" max="4" placeholder="e.g., 3.75" />
                                <x-input-error :messages="$errors->get('gpa')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div>
                                <x-input-label for="notes" :value="__('Notes / Additional Information')" />
                                <textarea id="notes" name="notes" rows="3" 
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Any additional notes about the student...">{{ old('notes', $student->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Job Interests -->
                        <div class="mt-6">
                            <x-input-label for="interests" :value="__('Job Interests')" />
                            <p class="text-sm text-gray-600 mb-2">Enter job roles/interests (one per line)</p>
                            <div id="interests-container">
                                @forelse(old('interests', $student->interests->pluck('interest')->toArray()) as $index => $interest)
                                    <div class="flex gap-2 mb-2 interest-row">
                                        <x-text-input 
                                            class="flex-1" 
                                            type="text" 
                                            name="interests[]" 
                                            value="{{ $interest }}" 
                                            placeholder="e.g., Web Developer, Data Analyst" 
                                        />
                                        <button type="button" onclick="removeInterest(this)" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                                    </div>
                                @empty
                                    <div class="flex gap-2 mb-2 interest-row">
                                        <x-text-input 
                                            class="flex-1" 
                                            type="text" 
                                            name="interests[]" 
                                            placeholder="e.g., Web Developer, Data Analyst" 
                                        />
                                        <button type="button" onclick="removeInterest(this)" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="addInterest()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                + Add Interest
                            </button>
                            <x-input-error :messages="$errors->get('interests')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Student') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addInterest() {
            const container = document.getElementById('interests-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex gap-2 mb-2 interest-row';
            newRow.innerHTML = `
                <input 
                    class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                    type="text" 
                    name="interests[]" 
                    placeholder="e.g., Web Developer, Data Analyst" 
                />
                <button type="button" onclick="removeInterest(this)" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeInterest(button) {
            const container = document.getElementById('interests-container');
            if (container.children.length > 1) {
                button.closest('.interest-row').remove();
            } else {
                alert('At least one interest field is required');
            }
        }
    </script>
</x-app-layout>
