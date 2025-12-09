<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Opportunity Announcement') }}
            </h2>
            <a href="{{ route('opportunities.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to List
            </a>
        </div>
    </x-slot>

    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Edit Opportunity</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('opportunities.update', $opportunity) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Company -->
                    <div class="mb-6">
                        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">Company <span class="text-red-500">*</span></label>
                        <select name="company_id" id="company_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('company_id') border-red-500 @enderror">
                            <option value="">Select a company...</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id', $opportunity->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Roles (Multiple) -->
                    <div class="mb-6">
                        <label for="roles_input" class="block text-sm font-medium text-gray-700 mb-2">Roles</label>
                        <div id="roles-container" class="mb-2 flex flex-wrap gap-2"></div>
                        <div class="flex gap-2">
                            <input type="text" id="roles_input" 
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                   placeholder="Type a role and press Enter...">
                            <button type="button" onclick="addRole()" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-150">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                        @error('roles')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div class="mb-6">
                        <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">Skills Required</label>
                        <textarea name="skills" id="skills" rows="3" 
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('skills') border-red-500 @enderror"
                                  placeholder="e.g., Java, Spring Boot, React, MySQL...">{{ old('skills', $opportunity->skills) }}</textarea>
                        @error('skills')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deadline & Announced Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                            <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $opportunity->deadline ? $opportunity->deadline->format('Y-m-d') : '') }}" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Announced Date & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="announced_at" class="block text-sm font-medium text-gray-700 mb-2">Announced Date <span class="text-red-500">*</span></label>
                            <input type="date" name="announced_at" id="announced_at" value="{{ old('announced_at', $opportunity->announced_at->format('Y-m-d')) }}" required 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('announced_at') border-red-500 @enderror">
                            @error('announced_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('status') border-red-500 @enderror">
                                <option value="Open" {{ old('status', $opportunity->status) == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="Closed" {{ old('status', $opportunity->status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                                <option value="Filled" {{ old('status', $opportunity->status) == 'Filled' ? 'selected' : '' }}>Filled</option>
                                <option value="Expired" {{ old('status', $opportunity->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Person & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $opportunity->contact_person) }}" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('contact_person') border-red-500 @enderror"
                                   placeholder="e.g., John Doe">
                            @error('contact_person')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $opportunity->contact_email) }}" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('contact_email') border-red-500 @enderror"
                                   placeholder="e.g., john@example.com">
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Document Upload -->
                    <div class="mb-6">
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Attachment (PDF/JPG/PNG, max 5MB)</label>
                        @if($opportunity->document_path)
                            <div class="mb-2 p-3 bg-gray-50 rounded-lg flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-gray-400 mr-2"></i>
                                    <span class="text-sm text-gray-700">Current file: {{ basename($opportunity->document_path) }}</span>
                                </div>
                                <a href="{{ Storage::url($opportunity->document_path) }}" target="_blank" class="text-teal-600 hover:text-teal-800">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        @endif
                        <input type="file" name="document" id="document" accept=".pdf,.jpg,.jpeg,.png" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('document') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Leave empty to keep current file</p>
                        @error('document')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="mb-6">
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" 
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('remarks') border-red-500 @enderror"
                                  placeholder="Any additional notes...">{{ old('remarks', $opportunity->remarks) }}</textarea>
                        @error('remarks')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">
                            Update Opportunity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Define functions globally first
        let roles = @json(old('roles', $opportunity->roles ?? []));
        
        console.log('Initial roles:', roles);

        function renderRoles() {
            const container = document.getElementById('roles-container');
            if (!container) {
                console.error('roles-container not found');
                return;
            }
            
            console.log('Rendering roles:', roles);
            container.innerHTML = '';
            
            if (!roles || roles.length === 0) {
                console.log('No roles to render');
                return;
            }
            
            roles.forEach((role, index) => {
                // Create wrapper for badge and hidden input
                const wrapper = document.createElement('div');
                wrapper.className = 'inline-flex items-center';
                
                // Create visible badge
                const badge = document.createElement('span');
                badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800';
                
                const roleText = document.createElement('span');
                roleText.textContent = role;
                badge.appendChild(roleText);
                
                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'ml-2 text-teal-600 hover:text-teal-800';
                removeBtn.onclick = function() { removeRole(index); };
                removeBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                `;
                badge.appendChild(removeBtn);
                
                wrapper.appendChild(badge);
                
                // Create hidden input
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'roles[]';
                hiddenInput.value = role;
                wrapper.appendChild(hiddenInput);
                
                container.appendChild(wrapper);
            });
        }

        function addRole() {
            const input = document.getElementById('roles_input');
            if (!input) {
                console.error('roles_input not found');
                return;
            }
            
            const role = input.value.trim();
            console.log('Adding role:', role);
            
            if (role && !roles.includes(role)) {
                roles.push(role);
                console.log('Role added, current roles:', roles);
                renderRoles();
                input.value = '';
            } else if (role && roles.includes(role)) {
                alert('This role has already been added');
            }
        }

        function removeRole(index) {
            console.log('Removing role at index:', index);
            roles.splice(index, 1);
            renderRoles();
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const rolesInput = document.getElementById('roles_input');
            if (rolesInput) {
                rolesInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addRole();
                    }
                });
            }

            // Initialize roles on page load
            console.log('Initializing roles display');
            renderRoles();
        });
    </script>
</x-app-layout>
