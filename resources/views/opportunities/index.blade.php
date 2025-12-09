<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Opportunity Announcements') }}
            </h2>
            <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">
                Add New Opportunity
            </a>
        </div>
    </x-slot>



    <!-- Page Banner -->
    <div class="overflow-hidden shadow-sm bg-gradient-to-r from-teal-400 to-cyan-600 sm:rounded-lg">
        <div class="p-6 text-center text-white">
            <h3 class="text-2xl font-bold">Vacancies Announcements Management</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            @if(session('success'))
                <div class="p-4 text-green-800 border-l-4 border-green-500 rounded-lg shadow-sm bg-green-50">
                    <div class="flex items-center">
                        <i class="mr-3 text-green-500 fas fa-check-circle"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif



            <!-- Filters -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('opportunities.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">All Statuses</option>
                                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                <option value="Filled" {{ request('status') == 'Filled' ? 'selected' : '' }}>Filled</option>
                                <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>

                        <div>
                            <label for="company_id" class="block mb-1 text-sm font-medium text-gray-700">Company</label>
                            <select name="company_id" id="company_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">All Companies</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="search" class="block mb-1 text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Title, skills, company..." 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="flex items-end space-x-2">
                            <button type="submit" class="flex-1 px-4 py-2 text-white bg-teal-600 rounded-md hover:bg-teal-700">
                                Filter
                            </button>
                            <a href="{{ route('opportunities.index') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                Clear
                            </a>
                            <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 text-white bg-teal-600 rounded-md hover:bg-teal-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add New
                            </a>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Opportunities Table -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-1/5 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Company</th>
                                <th scope="col" class="w-1/5 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Roles</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">Deadline</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">Announced</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase w-1/8">Status</th>
                                <th scope="col" class="w-1/4 px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($opportunities as $opportunity)
                                <tr class="transition duration-150 hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <!-- Company Logo -->
                                            <div class="flex-shrink-0 mr-4">
                                                @php
                                                    // Generate multiple logo sources with aggressive domain detection
                                                    $logoSources = [];
                                                    
                                                    // Method 1: Use website domain if available
                                                    if(!empty($opportunity->company->website)) {
                                                        $domain = parse_url($opportunity->company->website, PHP_URL_HOST) ?? $opportunity->company->website;
                                                        $domain = str_replace(['www.', 'http://', 'https://'], '', strtolower($domain));
                                                        $logoSources[] = "https://logo.clearbit.com/{$domain}";
                                                    }
                                                    
                                                    // Method 2: Extract domain from email
                                                    if(!empty($opportunity->company->contact_email)) {
                                                        $emailDomain = substr(strrchr($opportunity->company->contact_email, "@"), 1);
                                                        if($emailDomain && !in_array($emailDomain, ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'live.com'])) {
                                                            $logoSources[] = "https://logo.clearbit.com/{$emailDomain}";
                                                        }
                                                    }
                                                    
                                                    // Method 3: Guess common domains from company name
                                                    $companyName = strtolower(trim($opportunity->company->name));
                                                    $cleanName = preg_replace('/[^a-z0-9]/', '', str_replace([' inc', ' ltd', ' llc', ' corp', ' company', ' co', ' pvt', ' private', ' limited'], '', $companyName));
                                                    if(strlen($cleanName) >= 3) {
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.com";
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.lk"; // Sri Lankan domains
                                                        $logoSources[] = "https://logo.clearbit.com/{$cleanName}.org";
                                                    }
                                                    
                                                    // Method 4: Try with common variations
                                                    $words = explode(' ', strtolower(trim($opportunity->company->name)));
                                                    if(count($words) >= 1) {
                                                        $firstWord = preg_replace('/[^a-z0-9]/', '', $words[0]);
                                                        if(strlen($firstWord) >= 3) {
                                                            $logoSources[] = "https://logo.clearbit.com/{$firstWord}.com";
                                                        }
                                                    }
                                                    
                                                    // Remove duplicates
                                                    $logoSources = array_unique($logoSources);
                                                @endphp
                                                
                                                <div class="relative w-16 h-16">
                                                    <!-- Company Logo Image -->
                                                    @if(count($logoSources) > 0)
                                                        <img id="logo-{{ $opportunity->id }}" 
                                                             src="{{ $logoSources[0] }}" 
                                                             alt="{{ $opportunity->company->name }} logo"
                                                             class="absolute inset-0 object-contain w-16 h-16 p-2 bg-white border border-gray-200 rounded-md shadow-sm"
                                                             style="display: block;"
                                                             onload="this.style.display='block'; document.getElementById('fallback-{{ $opportunity->id }}').style.display='none';"
                                                             onerror="handleLogoError(this, {{ json_encode(array_slice($logoSources, 1)) }}, '{{ $opportunity->id }}')">
                                                    @endif
                                                    
                                                    <!-- Fallback with company initial -->
                                                    <div id="fallback-{{ $opportunity->id }}" 
                                                         class="absolute inset-0 flex items-center justify-center w-16 h-16 text-white border border-gray-200 rounded-md shadow-sm bg-gradient-to-br from-teal-500 to-blue-600"
                                                         style="display: {{ count($logoSources) > 0 ? 'none' : 'flex' }};">
                                                        <span class="text-lg font-bold">{{ strtoupper(substr($opportunity->company->name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Company Info -->
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-semibold text-gray-900">{{ $opportunity->company->name }}</div>
                                                @if($opportunity->company->industry)
                                                    <div class="text-xs text-gray-500">{{ $opportunity->company->industry }}</div>
                                                @endif
                                                @if($opportunity->company->type)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                                        @if($opportunity->company->type === 'IT') bg-blue-100 text-blue-800
                                                        @elseif($opportunity->company->type === 'Partner') bg-green-100 text-green-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ $opportunity->company->type }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @if(!empty($opportunity->roles))
                                                @foreach($opportunity->roles as $role)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-teal-100 text-teal-800">
                                                        {{ $role }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-sm text-gray-400">No roles specified</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $opportunity->deadline ? $opportunity->deadline->format('M d, Y') : 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $opportunity->announced_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'Open' => 'bg-green-100 text-green-800',
                                                'Closed' => 'bg-gray-100 text-gray-800',
                                                'Filled' => 'bg-blue-100 text-blue-800',
                                                'Expired' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$opportunity->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $opportunity->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('opportunities.show', $opportunity) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-teal-600 hover:text-teal-900 border border-teal-600 rounded-md hover:bg-teal-50 transition" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('opportunities.edit', $opportunity) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-900 border border-blue-600 rounded-md hover:bg-blue-50 transition" title="Edit Opportunity">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this opportunity?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-red-600 hover:text-red-900 border border-red-600 rounded-md hover:bg-red-50 transition" title="Delete Opportunity">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                            <a href="{{ route('opportunities.apply-students', $opportunity) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-teal-600 text-white rounded-md hover:bg-teal-700 transition" title="Apply Students to this Opportunity">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                                </svg>
                                                Apply Students
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <i class="mb-4 text-5xl fas fa-bullhorn"></i>
                                            <p class="text-lg font-medium">No opportunity announcements found</p>
                                            <p class="mt-2 text-sm">Create your first opportunity announcement to get started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($opportunities->hasPages())
                    <div class="px-4 py-3 bg-white border-t border-gray-200">
                        {{ $opportunities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function handleLogoError(img, fallbackUrls, opportunityId) {
            // Hide the failed image
            img.style.display = 'none';
            
            // Try next URL in the fallback array
            if (fallbackUrls && fallbackUrls.length > 0) {
                const nextUrl = fallbackUrls.shift();
                
                // Update the same image element instead of creating new ones
                img.src = nextUrl;
                img.onload = function() {
                    this.style.display = 'block';
                    const fallbackDiv = document.getElementById('fallback-' + opportunityId);
                    if (fallbackDiv) {
                        fallbackDiv.style.display = 'none';
                    }
                };
                img.onerror = function() {
                    handleLogoError(this, fallbackUrls, opportunityId);
                };
                
                // Show image again to try loading
                img.style.display = 'block';
            } else {
                // All URLs failed, show the fallback div with company initial
                const fallbackDiv = document.getElementById('fallback-' + opportunityId);
                if (fallbackDiv) {
                    fallbackDiv.style.display = 'flex';
                }
                img.style.display = 'none';
            }
        }

        // Add a timeout for logo loading to show fallback faster
        document.addEventListener('DOMContentLoaded', function() {
            const logoImages = document.querySelectorAll('img[id^="logo-"]');
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
    </script>

</x-app-layout>
