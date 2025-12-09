<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Companies') }}
            </h2>
            <a href="{{ route('companies.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                Add New Company
            </a>
        </div>
    </x-slot>

    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Companies Management</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('companies.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Company name, contact person, email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">All Types</option>
                                <option value="IT" {{ request('type') === 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="Non-IT" {{ request('type') === 'Non-IT' ? 'selected' : '' }}>Non-IT</option>
                                <option value="Partner" {{ request('type') === 'Partner' ? 'selected' : '' }}>Partner</option>
                                <option value="Other" {{ request('type') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="md:col-span-3 flex justify-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Filter
                            </button>
                            <a href="{{ route('companies.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Companies Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($companies->isEmpty())
                        <p class="text-gray-500 text-center py-12">
                            No companies found. <a href="{{ route('companies.create') }}" class="text-green-600 hover:text-green-900">Add your first company</a>
                        </p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($companies as $company)
                                <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-lg transition-shadow">
                                    <div class="p-6">
                                        <div class="flex items-start space-x-4 mb-4">
                                            <!-- Company Logo -->
                                            <div class="flex-shrink-0">
                                                @php
                                                    // Generate multiple logo sources with aggressive domain detection
                                                    $logoSources = [];
                                                    
                                                    // Method 1: Use website domain if available
                                                    if(!empty($company->website)) {
                                                        $domain = parse_url($company->website, PHP_URL_HOST) ?? $company->website;
                                                        $domain = str_replace(['www.', 'http://', 'https://'], '', strtolower($domain));
                                                        $logoSources[] = "https://logo.clearbit.com/{$domain}";
                                                    }
                                                    
                                                    // Method 2: Extract domain from email
                                                    if(!empty($company->contact_email)) {
                                                        $emailDomain = substr(strrchr($company->contact_email, "@"), 1);
                                                        if($emailDomain && !in_array($emailDomain, ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'live.com'])) {
                                                            $logoSources[] = "https://logo.clearbit.com/{$emailDomain}";
                                                        }
                                                    }
                                                    
                                                    // Method 3: Guess common domains from company name
                                                    $companyName = strtolower(trim($company->name));
                                                    $cleanName = preg_replace('/[^a-z0-9]/', '', str_replace([' inc', ' ltd', ' llc', ' corp', ' company', ' co', ' pvt', ' private', ' limited'], '', $companyName));
                                                    if(strlen($cleanName) >= 3) {
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.com";
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.lk"; // Sri Lankan domains
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.org";
                                                    }
                                                    
                                                    // Method 4: Try with common variations
                                                    $words = explode(' ', strtolower(trim($company->name)));
                                                    if(count($words) >= 1) {
                                                        $firstWord = preg_replace('/[^a-z0-9]/', '', $words[0]);
                                                        if(strlen($firstWord) >= 3) {
                                                            $logoSources[] = "https://logo.clearbit.com/{$firstWord}.com";
                                                        }
                                                    }
                                                    
                                                    // Remove duplicates
                                                    $logoSources = array_unique($logoSources);
                                                @endphp
                                                
                                                <div class="relative w-24 h-24">
                                                    <!-- Company Logo Image -->
                                                    @if(count($logoSources) > 0)
                                                        <img id="company-logo-{{ $company->id }}" 
                                                             src="{{ $logoSources[0] }}" 
                                                             alt="{{ $company->name }} logo"
                                                             class="absolute inset-0 object-contain w-24 h-24 p-2 bg-white border border-gray-200 rounded-md shadow-sm"
                                                             style="display: block;"
                                                             onload="this.style.display='block'; document.getElementById('company-fallback-{{ $company->id }}').style.display='none';"
                                                             onerror="handleCompanyLogoError(this, {{ json_encode(array_slice($logoSources, 1)) }}, '{{ $company->id }}')">
                                                    @endif
                                                    
                                                    <!-- Fallback with company initial -->
                                                    <div id="company-fallback-{{ $company->id }}" 
                                                         class="absolute inset-0 flex items-center justify-center w-24 h-24 text-white border border-gray-200 rounded-md shadow-sm bg-gradient-to-br from-green-500 to-teal-600"
                                                         style="display: {{ count($logoSources) > 0 ? 'none' : 'flex' }};">
                                                        <span class="text-2xl font-bold">{{ strtoupper(substr($company->name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Company Info -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start mb-2">
                                                    <h3 class="text-xl font-bold text-gray-900 truncate">{{ $company->name }}</h3>
                                                    @if($company->type)
                                                        <span class="ml-2 px-2 py-1 text-xs rounded-full flex-shrink-0
                                                            @if($company->type === 'IT') bg-blue-100 text-blue-800
                                                            @elseif($company->type === 'Partner') bg-green-100 text-green-800
                                                            @else bg-gray-100 text-gray-800
                                                            @endif">
                                                            {{ $company->type }}
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                @if($company->industry)
                                                    <p class="text-sm text-gray-500 mb-2">{{ $company->industry }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                                            @if($company->contact_person_name)
                                                <p><span class="font-medium">Contact:</span> {{ $company->contact_person_name }}</p>
                                            @endif
                                            @if($company->contact_email)
                                                <p><span class="font-medium">Email:</span> {{ $company->contact_email }}</p>
                                            @endif
                                            @if($company->contact_phone)
                                                <p><span class="font-medium">Phone:</span> {{ $company->contact_phone }}</p>
                                            @endif
                                        </div>

                                        <div class="flex justify-between items-center pt-4 border-t">
                                            <div class="text-sm text-gray-500">
                                                <span class="font-medium">{{ $company->vacancies_count }}</span> vacancies •
                                                <span class="font-medium">{{ $company->applications_count }}</span> applications
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('companies.show', $company) }}" class="text-green-600 hover:text-green-900">View</a>
                                                <a href="{{ route('companies.edit', $company) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDeleteCompany(this, '{{ $company->name }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pagination -->
            @if($companies->hasPages())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{ $companies->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function handleCompanyLogoError(img, fallbackUrls, companyId) {
            // Hide the failed image
            img.style.display = 'none';
            
            // Try next URL in the fallback array
            if (fallbackUrls && fallbackUrls.length > 0) {
                const nextUrl = fallbackUrls.shift();
                
                // Update the same image element instead of creating new ones
                img.src = nextUrl;
                img.onload = function() {
                    this.style.display = 'block';
                    const fallbackDiv = document.getElementById('company-fallback-' + companyId);
                    if (fallbackDiv) {
                        fallbackDiv.style.display = 'none';
                    }
                };
                img.onerror = function() {
                    handleCompanyLogoError(this, fallbackUrls, companyId);
                };
                
                // Show image again to try loading
                img.style.display = 'block';
            } else {
                // All URLs failed, show the fallback div with company initial
                const fallbackDiv = document.getElementById('company-fallback-' + companyId);
                if (fallbackDiv) {
                    fallbackDiv.style.display = 'flex';
                }
                img.style.display = 'none';
            }
        }

        // Add a timeout for logo loading to show fallback faster
        document.addEventListener('DOMContentLoaded', function() {
            const logoImages = document.querySelectorAll('img[id^="company-logo-"]');
            logoImages.forEach(function(img) {
                const timeoutId = setTimeout(function() {
                    if (!img.complete || !img.naturalWidth) {
                        // Image hasn't loaded, trigger error handler
                        if (img.onerror) {
                            img.onerror();
                        }
                    }
                }, 3000); // 3 second timeout
                
                img.onload = function() {
                    clearTimeout(timeoutId);
                };
            });
        });

        function confirmDeleteCompany(button, companyName) {
            Swal.fire({
                title: 'Delete Company?',
                html: `<p>Are you sure you want to delete <strong>${companyName}</strong>?</p>
                       <p class="text-sm text-gray-600 mt-2">This will also delete all associated vacancies and applications!</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-5 py-2.5',
                    cancelButton: 'rounded-lg px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Submit the form
                    button.closest('form').submit();
                }
            });
        }
    </script>
</x-app-layout>
