<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Opportunity Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('opportunities.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
                <a href="{{ route('opportunities.edit', $opportunity) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-teal-500 via-cyan-600 to-blue-700 overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative px-6 py-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Company Logo -->
                        @php
                            $logoSrc = null;
                            
                            // Use the company's logo_url attribute which now uses Google Favicon API
                            if ($opportunity->company->logo_url) {
                                $logoSrc = $opportunity->company->logo_url;
                            }
                        @endphp
                        
                        @if($logoSrc)
                            <img src="{{ $logoSrc }}" 
                                 alt="{{ $opportunity->company->name }}" 
                                 class="h-16 w-16 rounded-xl bg-white/90 p-2 shadow-lg object-contain"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        
                        <div class="h-16 w-16 rounded-xl bg-white/90 flex items-center justify-center shadow-lg {{ $logoSrc ? 'hidden' : '' }}" id="logo-fallback-{{ $opportunity->id }}">
                            <span class="text-teal-600 font-bold text-xl">{{ substr($opportunity->company->name, 0, 1) }}</span>
                        </div>
                        
                        <div class="text-white">
                            <h1 class="text-3xl font-bold mb-2">{{ $opportunity->company->name }}</h1>
                            <p class="text-teal-100 text-lg">Internship Opportunity</p>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    @php
                        $statusStyles = [
                            'Open' => 'bg-green-500/90 text-white border-green-400',
                            'Closed' => 'bg-gray-500/90 text-white border-gray-400',
                            'Filled' => 'bg-blue-500/90 text-white border-blue-400',
                            'Expired' => 'bg-red-500/90 text-white border-red-400',
                        ];
                    @endphp
                    <div class="flex items-center space-x-4">
                        <span class="px-6 py-3 rounded-full text-lg font-semibold border-2 {{ $statusStyles[$opportunity->status] ?? 'bg-gray-500/90 text-white border-gray-400' }}">
                            {{ $opportunity->status }}
                        </span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-white">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Announced</p>
                            <p class="font-semibold">{{ $opportunity->announced_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Application Deadline</p>
                            <p class="font-semibold">
                                @if($opportunity->deadline)
                                    {{ $opportunity->deadline->format('M d, Y') }}
                                @else
                                    No deadline set
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm">Applications</p>
                            <p class="font-semibold">{{ $opportunity->applications->count() }} received</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-8 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500 text-lg"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Opportunity Overview Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 px-6 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-teal-600 mr-3"></i>
                            Opportunity Overview
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Available Roles -->
                        @if(!empty($opportunity->roles))
                            <div class="bg-teal-50 p-4 rounded-lg border-l-4 border-teal-400">
                                <h4 class="text-lg font-semibold text-teal-800 mb-3 flex items-center">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    Available Positions
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($opportunity->roles as $role)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-teal-100 text-teal-800 border border-teal-200">
                                            <i class="fas fa-user-tie mr-2"></i>{{ $role }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Skills Required -->
                        @if($opportunity->skills)
                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                                <h4 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                                    <i class="fas fa-cogs mr-2"></i>
                                    Required Skills
                                </h4>
                                <p class="text-gray-700 leading-relaxed">{{ $opportunity->skills }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact & Documents Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-address-book text-purple-600 mr-3"></i>
                            Contact & Resources
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Contact Information -->
                        @if($opportunity->contact_person || $opportunity->contact_email)
                            <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-400">
                                <h4 class="text-lg font-semibold text-purple-800 mb-3 flex items-center">
                                    <i class="fas fa-user-circle mr-2"></i>
                                    Contact Information
                                </h4>
                                <div class="space-y-3">
                                    @if($opportunity->contact_person)
                                        <div class="flex items-center bg-white p-3 rounded-lg">
                                            <i class="fas fa-user text-purple-600 w-5 mr-3"></i>
                                            <span class="text-gray-700 font-medium">{{ $opportunity->contact_person }}</span>
                                        </div>
                                    @endif
                                    @if($opportunity->contact_email)
                                        <div class="flex items-center bg-white p-3 rounded-lg">
                                            <i class="fas fa-envelope text-purple-600 w-5 mr-3"></i>
                                            <a href="mailto:{{ $opportunity->contact_email }}" class="text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200">
                                                {{ $opportunity->contact_email }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Attached Document -->
                        @if($opportunity->document_path)
                            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-400">
                                <h4 class="text-lg font-semibold text-red-800 mb-3 flex items-center">
                                    <i class="fas fa-file-download mr-2"></i>
                                    Attached Document
                                </h4>
                                <div class="bg-white p-4 rounded-lg flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-3 bg-red-100 rounded-lg mr-4">
                                            <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-medium text-gray-900">{{ basename($opportunity->document_path) }}</p>
                                            <p class="text-sm text-gray-500">Click to download the opportunity details</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($opportunity->document_path) }}" 
                                       target="_blank" 
                                       class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Remarks -->
                        @if($opportunity->remarks)
                            <div class="bg-amber-50 p-4 rounded-lg border-l-4 border-amber-400">
                                <h4 class="text-lg font-semibold text-amber-800 mb-3 flex items-center">
                                    <i class="fas fa-sticky-note mr-2"></i>
                                    Additional Notes
                                </h4>
                                <div class="bg-white p-4 rounded-lg">
                                    <p class="text-gray-700 leading-relaxed">{{ $opportunity->remarks }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="space-y-8">
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-bolt text-indigo-600 mr-3"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($opportunity->status === 'Open')
                            <form action="{{ route('opportunities.mark-filled', $opportunity) }}" method="POST" onsubmit="return confirm('Mark this opportunity as filled?');" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-check-circle mr-2"></i>Mark as Filled
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('opportunities.edit', $opportunity) }}" class="block w-full bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-edit mr-2"></i>Edit Details
                        </a>
                        <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this opportunity?');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-trash mr-2"></i>Delete Opportunity
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Enhanced Timeline Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-teal-50 px-6 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-history text-green-600 mr-3"></i>
                            Opportunity Timeline
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="relative">
                            <!-- Timeline line -->
                            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-teal-400 via-green-400 to-blue-400"></div>
                            
                            <div class="space-y-8">
                                <!-- Created Event -->
                                <div class="relative flex items-start">
                                    <div class="relative z-10 flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg border-4 border-white">
                                            <i class="fas fa-plus text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-teal-50 p-4 rounded-lg border-l-4 border-teal-400">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-semibold text-teal-800">Opportunity Created</h4>
                                            <span class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">{{ $opportunity->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-teal-700">{{ $opportunity->created_at->format('l, F j, Y \a\t g:i A') }}</p>
                                        <p class="text-xs text-teal-600 mt-1">Initial opportunity setup completed</p>
                                    </div>
                                </div>

                                <!-- Announced Event -->
                                <div class="relative flex items-start">
                                    <div class="relative z-10 flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg border-4 border-white">
                                            <i class="fas fa-bullhorn text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-semibold text-blue-800">Publicly Announced</h4>
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $opportunity->announced_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-blue-700">{{ $opportunity->announced_at->format('l, F j, Y') }}</p>
                                        <p class="text-xs text-blue-600 mt-1">Available for student applications</p>
                                    </div>
                                </div>

                                <!-- Applications Milestone -->
                                @if($opportunity->applications->count() > 0)
                                    <div class="relative flex items-start">
                                        <div class="relative z-10 flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg border-4 border-white">
                                                <i class="fas fa-users text-white text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="ml-6 flex-1 bg-purple-50 p-4 rounded-lg border-l-4 border-purple-400">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-semibold text-purple-800">Applications Received</h4>
                                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">{{ $opportunity->applications->count() }} total</span>
                                            </div>
                                            <p class="text-sm text-purple-700">First application: {{ $opportunity->applications->first()->created_at->format('M j, Y') }}</p>
                                            <p class="text-xs text-purple-600 mt-1">Students showing interest</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Deadline Event -->
                                @if($opportunity->deadline)
                                    <div class="relative flex items-start">
                                        <div class="relative z-10 flex-shrink-0">
                                            @php
                                                $isPast = $opportunity->deadline->isPast();
                                                $isToday = $opportunity->deadline->isToday();
                                                $isSoon = !$isPast && $opportunity->deadline->diffInDays() <= 3;
                                            @endphp
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br {{ $isPast ? 'from-red-500 to-red-600' : ($isToday || $isSoon ? 'from-orange-500 to-orange-600' : 'from-yellow-500 to-yellow-600') }} flex items-center justify-center shadow-lg border-4 border-white">
                                                <i class="fas fa-{{ $isPast ? 'times-circle' : 'calendar-times' }} text-white text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="ml-6 flex-1 bg-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-50 p-4 rounded-lg border-l-4 border-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-400">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-semibold text-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-800">
                                                    Application {{ $isPast ? 'Deadline Passed' : 'Deadline' }}
                                                </h4>
                                                <span class="text-xs bg-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-100 text-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-700 px-2 py-1 rounded-full">
                                                    {{ $isPast ? 'Overdue' : ($isToday ? 'Today!' : $opportunity->deadline->diffForHumans()) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-700">{{ $opportunity->deadline->format('l, F j, Y') }}</p>
                                            <p class="text-xs text-{{ $isPast ? 'red' : ($isToday || $isSoon ? 'orange' : 'yellow') }}-600 mt-1">
                                                @if($isPast)
                                                    No longer accepting applications
                                                @elseif($isToday)
                                                    Last day for applications!
                                                @elseif($isSoon)
                                                    Applications closing soon
                                                @else
                                                    Applications still open
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Current Status -->
                                <div class="relative flex items-start">
                                    <div class="relative z-10 flex-shrink-0">
                                        @php
                                            $statusConfig = [
                                                'Open' => ['icon' => 'fa-door-open', 'bg' => 'from-green-500 to-green-600', 'color' => 'green'],
                                                'Closed' => ['icon' => 'fa-door-closed', 'bg' => 'from-gray-500 to-gray-600', 'color' => 'gray'],
                                                'Filled' => ['icon' => 'fa-check-circle', 'bg' => 'from-blue-500 to-blue-600', 'color' => 'blue'],
                                                'Expired' => ['icon' => 'fa-times-circle', 'bg' => 'from-red-500 to-red-600', 'color' => 'red'],
                                            ];
                                            $currentStatus = $statusConfig[$opportunity->status] ?? $statusConfig['Open'];
                                        @endphp
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br {{ $currentStatus['bg'] }} flex items-center justify-center shadow-lg border-4 border-white">
                                            <i class="fas {{ $currentStatus['icon'] }} text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-6 flex-1 bg-{{ $currentStatus['color'] }}-50 p-4 rounded-lg border-l-4 border-{{ $currentStatus['color'] }}-400">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-semibold text-{{ $currentStatus['color'] }}-800">Current Status: {{ $opportunity->status }}</h4>
                                            <span class="text-xs bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['color'] }}-700 px-2 py-1 rounded-full">Active</span>
                                        </div>
                                        <p class="text-sm text-{{ $currentStatus['color'] }}-700">Last updated: {{ $opportunity->updated_at->format('M j, Y \a\t g:i A') }}</p>
                                        <p class="text-xs text-{{ $currentStatus['color'] }}-600 mt-1">{{ $opportunity->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applications Summary Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-user-graduate text-blue-600 mr-3"></i>
                                Applications
                            </h3>
                            <div class="flex items-center space-x-2">
                                <span class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full border border-blue-200">
                                    {{ $opportunity->applications->count() }} Total
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($opportunity->applications->count() > 0)
                            <!-- Application Stats -->
                            @php
                                $statusCounts = $opportunity->applications->groupBy('status')->map->count();
                            @endphp
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                @foreach(['Pending', 'Approved', 'Rejected', 'Interview'] as $status)
                                    @if($statusCounts->get($status, 0) > 0)
                                        <div class="bg-gray-50 p-3 rounded-lg text-center">
                                            <div class="text-2xl font-bold text-gray-800">{{ $statusCounts->get($status, 0) }}</div>
                                            <div class="text-xs text-gray-600">{{ $status }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Recent Applications -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-800 border-b pb-2">Recent Applications</h4>
                                @foreach($opportunity->applications->take(3) as $application)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-semibold text-sm">
                                                        {{ substr($application->student->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <h5 class="text-sm font-medium text-gray-900">{{ $application->student->name }}</h5>
                                                <p class="text-xs text-gray-600">{{ $application->student->student_id }} • {{ $application->student->programme }}</p>
                                                <p class="text-xs text-gray-500">Applied: {{ $application->sent_date ? $application->sent_date->format('M d') : $application->created_at->format('M d') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end space-y-2">
                                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                                @if($application->status === 'Approved') bg-green-100 text-green-800 border border-green-200
                                                @elseif($application->status === 'Rejected') bg-red-100 text-red-800 border border-red-200
                                                @elseif($application->status === 'Shortlisted') bg-yellow-100 text-yellow-800 border border-yellow-200
                                                @elseif($application->status === 'Interview') bg-blue-100 text-blue-800 border border-blue-200
                                                @elseif($application->status === 'CV Sent') bg-indigo-100 text-indigo-800 border border-indigo-200
                                                @else bg-gray-100 text-gray-800 border border-gray-200
                                                @endif">
                                                {{ $application->status }}
                                            </span>
                                            <a href="{{ route('applications.show', $application) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-xs font-medium hover:underline">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($opportunity->applications->count() > 3)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('applications.index', ['company_id' => $opportunity->company_id]) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-list mr-2"></i>
                                        View All {{ $opportunity->applications->count() }} Applications
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">No Applications Yet</h4>
                                <p class="text-gray-500 text-sm mb-4">Students will appear here after applying for this opportunity</p>
                                <div class="inline-flex items-center text-xs text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Applications are automatically tracked
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
