<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Company') }}
        </h2>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Add New Company</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div class="md:col-span-2">
                                <x-input-label for="name" :value="__('Company Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Company Type -->
                            <div>
                                <x-input-label for="type" :value="__('Company Type')" />
                                <select id="type" name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select Type</option>
                                    <option value="IT" {{ old('type') == 'IT' ? 'selected' : '' }}>IT</option>
                                    <option value="Non-IT" {{ old('type') == 'Non-IT' ? 'selected' : '' }}>Non-IT</option>
                                    <option value="Partner" {{ old('type') == 'Partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Industry -->
                            <div>
                                <x-input-label for="industry" :value="__('Industry Category')" />
                                <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" :value="old('industry')" placeholder="e.g., Software Development, Banking, Healthcare, Manufacturing" />
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Company Description')" />
                                <textarea id="description" name="description" rows="3"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                                    placeholder="Brief description of the company and its services...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" placeholder="Street address" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- City and Country -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" placeholder="e.g., Colombo" />
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="country" :value="__('Country')" />
                                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country', 'Sri Lanka')" placeholder="e.g., Sri Lanka" />
                                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Website -->
                            <div>
                                <x-input-label for="website" :value="__('Website')" />
                                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://example.com" />
                                <x-input-error :messages="$errors->get('website')" class="mt-2" />
                            </div>

                            <!-- Contact Person -->
                            <div>
                                <x-input-label for="contact_person_name" :value="__('Contact Person Name')" />
                                <x-text-input id="contact_person_name" class="block mt-1 w-full" type="text" name="contact_person_name" :value="old('contact_person_name')" />
                                <x-input-error :messages="$errors->get('contact_person_name')" class="mt-2" />
                            </div>

                            <!-- Contact Person Position -->
                            <div>
                                <x-input-label for="contact_person_position" :value="__('Contact Person Position')" />
                                <x-text-input id="contact_person_position" class="block mt-1 w-full" type="text" name="contact_person_position" :value="old('contact_person_position')" placeholder="e.g., HR Manager, CEO, Industry Liaison Officer" />
                                <x-input-error :messages="$errors->get('contact_person_position')" class="mt-2" />
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <x-input-label for="contact_email" :value="__('Contact Email')" />
                                <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email')" />
                                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <x-input-label for="contact_phone" :value="__('Contact Phone')" />
                                <x-text-input id="contact_phone" class="block mt-1 w-full" type="text" name="contact_phone" :value="old('contact_phone')" />
                                <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div>
                                <x-input-label for="notes" :value="__('Notes')" />
                                <textarea id="notes" name="notes" rows="3"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                                    placeholder="Additional notes or partnership details...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create Company') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
