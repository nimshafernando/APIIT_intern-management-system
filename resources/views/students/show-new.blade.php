<x-app-layout>
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Student Details</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Student Information Card - Editable -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Student Information</h3>
                        <button id="toggleEditMode" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                            Edit Information
                        </button>
                    </div>

                    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" id="studentForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- CB Number -->
                            <div>
                                <x-input-label for="student_id" value="CB Number" />
                                <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full view-mode" :value="old('student_id', $student->student_id)" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->student_id }}</p>
                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                            </div>

                            <!-- Full Name -->
                            <div>
                                <x-input-label for="name" value="Full Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full view-mode" :value="old('name', $student->name)" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->name }}</p>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full view-mode" :value="old('email', $student->email)" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->email }}</p>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone_number" value="Phone Number" />
                                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full view-mode" :value="old('phone_number', $student->phone_number)" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->phone_number }}</p>
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <x-input-label for="date_of_birth" value="Date of Birth" />
                                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full view-mode" :value="old('date_of_birth', $student->date_of_birth?->format('Y-m-d'))" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->date_of_birth?->format('M j, Y') ?? 'Not set' }}</p>
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <!-- Profile Photo -->
                            <div>
                                <x-input-label for="profile_photo" value="Profile Photo" />
                                <input id="profile_photo" name="profile_photo" type="file" accept="image/jpeg,image/png" class="mt-1 block w-full view-mode text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" disabled />
                                <p class="text-xs text-gray-500 mt-1 view-mode">JPG, PNG (Max 2MB) - Leave empty to keep current photo</p>
                                @if($student->profile_photo)
                                    <p class="text-sm text-gray-900 mt-1 edit-mode hidden">Photo uploaded</p>
                                @else
                                    <p class="text-sm text-gray-500 mt-1 edit-mode hidden">No photo uploaded</p>
                                @endif
                                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                            </div>

                            <!-- Programme -->
                            <div>
                                <x-input-label for="programme" value="Programme" />
                                <select id="programme" name="programme" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full view-mode" disabled>
                                    <option value="SE" {{ old('programme', $student->programme) == 'SE' ? 'selected' : '' }}>Software Engineering (SE)</option>
                                    <option value="CS" {{ old('programme', $student->programme) == 'CS' ? 'selected' : '' }}>Computer Science (CS)</option>
                                    <option value="CT" {{ old('programme', $student->programme) == 'CT' ? 'selected' : '' }}>Computing (CT)</option>
                                </select>
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->programme }}</p>
                                <x-input-error :messages="$errors->get('programme')" class="mt-2" />
                            </div>

                            <!-- Batch -->
                            <div>
                                <x-input-label for="batch" value="Batch" />
                                <x-text-input id="batch" name="batch" type="text" class="mt-1 block w-full view-mode" :value="old('batch', $student->batch)" placeholder="e.g., 23.2" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->batch }}</p>
                                <x-input-error :messages="$errors->get('batch')" class="mt-2" />
                            </div>

                            <!-- Semester -->
                            <div>
                                <x-input-label for="semester" value="Semester" />
                                <select id="semester" name="semester" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full view-mode" disabled>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $student->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">Semester {{ $student->semester }}</p>
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>

                            <!-- Cumulative Marks -->
                            <div>
                                <x-input-label for="cumulative_marks" value="Cumulative Marks (1-100%)" />
                                <x-text-input id="cumulative_marks" name="cumulative_marks" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full view-mode" :value="old('cumulative_marks', $student->cumulative_marks)" placeholder="e.g., 75.5" disabled />
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->cumulative_marks ? number_format($student->cumulative_marks, 2) . '%' : 'Not set' }}</p>
                                <x-input-error :messages="$errors->get('cumulative_marks')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" value="Notes / Additional Information" />
                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full view-mode" placeholder="Any additional notes about the student..." disabled>{{ old('notes', $student->notes) }}</textarea>
                                <p class="text-sm text-gray-900 mt-1 edit-mode hidden">{{ $student->notes ?? 'No notes' }}</p>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Save/Cancel Buttons -->
                        <div class="flex space-x-4 mt-6 view-mode hidden">
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

            <!-- Internship Interests - Editable -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Job Interests</h3>
                        <button id="toggleInterestsEdit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                            Edit Interests
                        </button>
                    </div>

                    <form action="{{ route('students.update', $student) }}" method="POST" id="interestsForm">
                        @csrf
                        @method('PUT')

                        <div id="interestsContainer" class="space-y-3">
                            @if($student->interests->count() > 0)
                                @foreach($student->interests as $index => $interest)
                                    <div class="interest-item">
                                        <div class="flex items-center space-x-3 interest-view">
                                            <div class="flex-1 p-4 bg-gray-50 rounded-lg">
                                                <p class="font-medium text-gray-900">{{ $interest->job_role }}</p>
                                                @if($interest->description)
                                                    <p class="text-sm text-gray-600 mt-1">{{ $interest->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="interest-edit hidden">
                                            <div class="flex space-x-3">
                                                <div class="flex-1">
                                                    <x-text-input name="interests[{{ $index }}][job_role]" type="text" class="mt-1 block w-full" :value="$interest->job_role" placeholder="e.g., Web Developer" />
                                                    <input type="hidden" name="interests[{{ $index }}][id]" value="{{ $interest->id }}">
                                                </div>
                                                <button type="button" class="remove-interest px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 interest-view">No interests specified</p>
                            @endif
                        </div>

                        <button type="button" id="addInterest" class="mt-4 px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 text-sm interest-edit hidden">
                            + Add Interest
                        </button>

                        <div class="flex space-x-4 mt-6 interest-edit hidden">
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

            <!-- Continue with Applications, Documents, etc. from original file -->
            @include('students.partials.applications-section')
            @include('students.partials.documents-section')

        </div>
    </div>

    <script>
        // Toggle edit mode for student information
        document.getElementById('toggleEditMode').addEventListener('click', function() {
            const viewModes = document.querySelectorAll('#studentForm .view-mode');
            const editModes = document.querySelectorAll('#studentForm .edit-mode');
            
            viewModes.forEach(el => {
                if (el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
                    el.disabled = !el.disabled;
                    if (!el.disabled) {
                        el.classList.remove('hidden');
                    }
                } else {
                    el.classList.toggle('hidden');
                }
            });
            
            editModes.forEach(el => el.classList.toggle('hidden'));
            
            this.textContent = this.textContent === 'Edit Information' ? 'View Mode' : 'Edit Information';
        });

        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('toggleEditMode').click();
            document.getElementById('studentForm').reset();
        });

        // Toggle edit mode for interests
        document.getElementById('toggleInterestsEdit').addEventListener('click', function() {
            const viewModes = document.querySelectorAll('.interest-view');
            const editModes = document.querySelectorAll('.interest-edit');
            
            viewModes.forEach(el => el.classList.toggle('hidden'));
            editModes.forEach(el => el.classList.toggle('hidden'));
            
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
            newInterest.className = 'interest-item interest-edit';
            newInterest.innerHTML = `
                <div class="flex space-x-3">
                    <div class="flex-1">
                        <input type="text" name="interests[${interestIndex}][job_role]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" placeholder="e.g., Web Developer">
                    </div>
                    <button type="button" class="remove-interest px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                        Remove
                    </button>
                </div>
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
