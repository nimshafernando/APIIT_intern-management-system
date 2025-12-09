<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Student') }}
            </h2>
            <a href="{{ route('students.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Add New Student</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
                @csrf

                <!-- Student ID -->
                <div>
                    <x-input-label for="student_id" value="CB Number *" />
                    <x-text-input id="student_id" type="text" name="student_id" :value="old('student_id')" required class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                </div>

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Full Name *" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email *" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_number" value="Phone Number *" />
                    <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number')" required class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-input-label for="date_of_birth" value="Date of Birth" />
                    <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>

                <!-- Profile Photo -->
                <div>
                    <x-input-label for="profile_photo" value="Profile Photo" />
                    <input id="profile_photo" type="file" name="profile_photo" accept="image/*"
                        class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG (Max 2MB)</p>
                    <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                </div>

                <!-- Programme, Batch, Semester in Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Programme -->
                    <div>
                        <label for="programme" class="block text-sm font-medium text-gray-700">Programme <span class="text-red-500">*</span></label>
                        <select name="programme" id="programme" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('programme') border-red-500 @enderror">
                            <option value="">Select Programme</option>
                            <option value="SE" {{ old('programme') === 'SE' ? 'selected' : '' }}>Software Engineering</option>
                            <option value="CS" {{ old('programme') === 'CS' ? 'selected' : '' }}>Computer Science</option>
                            <option value="CT" {{ old('programme') === 'CT' ? 'selected' : '' }}>Computing</option>
                        </select>
                        @error('programme')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batch -->
                    <div>
                        <label for="batch" class="block text-sm font-medium text-gray-700">Batch <span class="text-red-500">*</span></label>
                        <input type="text" name="batch" id="batch" value="{{ old('batch') }}" placeholder="e.g., 2024" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('batch') border-red-500 @enderror">
                        @error('batch')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester <span class="text-red-500">*</span></label>
                        <input type="number" name="semester" id="semester" value="{{ old('semester') }}" min="1" max="8" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('semester') border-red-500 @enderror">
                        @error('semester')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- GPA -->
                <div>
                    <x-input-label for="gpa" value="GPA (0.00 - 4.00)" />
                    <x-text-input id="gpa" type="number" name="gpa" :value="old('gpa')" step="0.01" min="0" max="4" class="block mt-1 w-full" placeholder="e.g., 3.75" />
                    <x-input-error :messages="$errors->get('gpa')" class="mt-2" />
                </div>

                <!-- Notes -->
                <div>
                    <x-input-label for="notes" value="Notes / Additional Information" />
                    <textarea id="notes" name="notes" rows="3" 
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Any additional notes about the student...">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <!-- Internship Interests (Optional) -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Internship Interests (Optional)</h3>
                    <div id="interests-container" class="space-y-3">
                        <div class="interest-row grid grid-cols-1 md:grid-cols-2 gap-3">
                            <input type="text" name="interests[0][job_role]" placeholder="Job Role (e.g., Software Developer)"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <input type="text" name="interests[0][description]" placeholder="Description (Optional)"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <button type="button" onclick="addInterest()" class="mt-3 text-sm text-indigo-600 hover:text-indigo-900">
                        + Add Another Interest
                    </button>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                    <x-primary-button>
                        Create Student
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>

<script>
let interestCount = 1;

function addInterest() {
    const container = document.getElementById('interests-container');
    const newRow = document.createElement('div');
    newRow.className = 'interest-row grid grid-cols-1 md:grid-cols-2 gap-3';
    newRow.innerHTML = `
        <input type="text" name="interests[${interestCount}][job_role]" placeholder="Job Role (e.g., Software Developer)"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <input type="text" name="interests[${interestCount}][description]" placeholder="Description (Optional)"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    `;
    container.appendChild(newRow);
    interestCount++;
}
</script>
</x-app-layout>
