<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white">
            <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h3>
            <p class="mt-2">Comprehensive analytics and insights for intern management</p>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            
            <!-- SECTION 1: Overview Statistics -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Overview Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                    <!-- Total Students -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-teal-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Total Students</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Companies -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Total Companies</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_companies'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Applications -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_applications'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Rate -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Approval Rate</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['approval_rate'] }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Applications -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-red-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Rejected Applications</p>
                                <p class="text-3xl font-bold text-red-600">{{ $stats['rejected_applications'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Placements -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Active Placements</p>
                                <p class="text-3xl font-bold text-indigo-600">{{ $stats['active_placements'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                <div class="bg-teal-500 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('students.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition">
                            <svg class="h-8 w-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Add Student</span>
                        </a>

                        <a href="{{ route('companies.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition">
                            <svg class="h-8 w-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Add Company</span>
                        </a>

                        <a href="{{ route('applications.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition">
                            <svg class="h-8 w-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Track Application</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Opportunity Announcements -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Vacancy Announcements</h3>
                    <a href="{{ route('opportunities.index') }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Closing Soon -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-white text-2xl mr-3"></i>
                                <div>
                                    <h4 class="text-white font-bold text-lg">Closing Soon</h4>
                                    <p class="text-orange-100 text-sm">Deadlines within 7 days</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @forelse($closingSoonOpportunities as $opportunity)
                                <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <a href="{{ route('opportunities.show', $opportunity) }}" class="font-semibold text-gray-900 hover:text-teal-600">
                                                @if(!empty($opportunity->roles))
                                                    {{ implode(', ', $opportunity->roles) }}
                                                @else
                                                    Internship Opportunity
                                                @endif
                                            </a>
                                            <p class="text-sm text-gray-600 mt-1">{{ $opportunity->company->name }}</p>
                                        </div>
                                        @php
                                            $statusColors = [
                                                'Open' => 'bg-green-100 text-green-800',
                                                'Closed' => 'bg-gray-100 text-gray-800',
                                                'Filled' => 'bg-blue-100 text-blue-800',
                                                'Expired' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$opportunity->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $opportunity->status }}
                                        </span>
                                    </div>
                                    @if($opportunity->deadline)
                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center text-red-600">
                                                <i class="fas fa-calendar-times mr-2"></i>
                                                <span class="font-medium">{{ $opportunity->deadline->format('M d, Y') }}</span>
                                            </div>
                                            <span class="text-gray-500">{{ $opportunity->deadline->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                                    <p class="text-gray-600">No urgent deadlines</p>
                                    <p class="text-sm text-gray-400 mt-1">All opportunities have sufficient time</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- New This Week -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-500 to-blue-500 px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-bullhorn text-white text-2xl mr-3"></i>
                                <div>
                                    <h4 class="text-white font-bold text-lg">New This Week</h4>
                                    <p class="text-teal-100 text-sm">Recently announced opportunities</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @forelse($newThisWeekOpportunities as $opportunity)
                                <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <a href="{{ route('opportunities.show', $opportunity) }}" class="font-semibold text-gray-900 hover:text-teal-600">
                                                @if(!empty($opportunity->roles))
                                                    {{ implode(', ', $opportunity->roles) }}
                                                @else
                                                    Internship Opportunity
                                                @endif
                                            </a>
                                            <p class="text-sm text-gray-600 mt-1">{{ $opportunity->company->name }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$opportunity->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $opportunity->status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar mr-2"></i>
                                            <span>{{ $opportunity->announced_at->format('M d, Y') }}</span>
                                        </div>
                                        @if(!empty($opportunity->roles))
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-briefcase mr-2"></i>
                                                <span>{{ count($opportunity->roles) }} role(s)</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-600">No new opportunities</p>
                                    <p class="text-sm text-gray-400 mt-1">Check back later for updates</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Application Analytics -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Application Analytics</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Monthly Trend Chart -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Monthly Application Trends</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="monthlyTrendChart" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Status Distribution Chart -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Application Status Distribution</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="statusChart" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Weekly Activity Summary -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Weekly Activity</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-500">This Week</span>
                                        <span class="text-2xl font-bold text-teal-600">{{ $stats['this_week_applications'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-teal-500 h-3 rounded-full" style="width: {{ $stats['this_week_applications'] > 0 ? min(($stats['this_week_applications'] / max($stats['this_week_applications'], $stats['last_week_applications'], 1)) * 100, 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-500">Last Week</span>
                                        <span class="text-2xl font-bold text-gray-600">{{ $stats['last_week_applications'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-gray-400 h-3 rounded-full" style="width: {{ $stats['last_week_applications'] > 0 ? min(($stats['last_week_applications'] / max($stats['this_week_applications'], $stats['last_week_applications'], 1)) * 100, 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                @php
                                    $weekChange = $stats['last_week_applications'] > 0 
                                        ? round((($stats['this_week_applications'] - $stats['last_week_applications']) / $stats['last_week_applications']) * 100, 1)
                                        : ($stats['this_week_applications'] > 0 ? 100 : 0);
                                @endphp
                                <div class="text-center pt-2 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 mb-1">Weekly Change</p>
                                    @if($weekChange > 0)
                                        <span class="text-lg font-bold text-green-600">↑ {{ $weekChange }}%</span>
                                    @elseif($weekChange < 0)
                                        <span class="text-lg font-bold text-red-600">↓ {{ abs($weekChange) }}%</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-600">No change</span>
                                    @endif
                                </div>
                                <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-200">
                                    <p>Monthly: <span class="font-semibold text-gray-900">{{ $stats['monthly_applications'] }}</span> applications</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Student Interests -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Top Student Interest Areas</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="interestsChart" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Top Companies Chart -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Top Companies by Applications</h4>
                        </div>
                        <div class="p-6">
                            @if($topCompanies->count() > 0)
                                <div class="space-y-3 mb-4">
                                    @foreach($topCompanies as $company)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <div class="flex-shrink-0">
                                                @if($company->logo_url)
                                                    <img src="{{ $company->logo_url }}" 
                                                         alt="{{ $company->name }}"
                                                         class="h-10 w-10 object-contain rounded-md bg-white border border-gray-200 p-1"
                                                         onerror="this.onerror=null; this.parentElement.innerHTML='<svg class=\'h-10 w-10 text-gray-300\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'></path></svg>';">
                                                @else
                                                    <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $company->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $company->industry ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <span class="ml-2 px-3 py-1 text-sm font-semibold bg-teal-100 text-teal-800 rounded-full flex-shrink-0">
                                            {{ $company->applications_count }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm text-center">No company data</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Recent Applications</h4>
                        </div>
                        <div class="p-6">
                            @if($recentApplications->count() > 0)
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    @foreach($recentApplications->take(5) as $application)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $application->student->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $application->company->name }} - {{ $application->position ?? 'N/A' }}</p>
                                        </div>
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full flex-shrink-0
                                            {{ $application->status == 'Approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $application->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $application->status == 'Submitted' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $application->status == 'Under Review' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ $application->status }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('applications.index') }}" class="text-sm text-teal-600 hover:underline font-medium">View all applications →</a>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm text-center">No applications yet</p>
                            @endif
                        </div>
                    </div>

                    <!-- Success Rate by Programme -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Success Rate by Programme</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="programmeSuccessChart" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Application Status Summary -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Application Summary</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-green-500 rounded-full p-2">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Approved</span>
                                    </div>
                                    <span class="text-2xl font-bold text-green-600">{{ $statusDistribution->where('status', 'Approved')->first()->count ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-yellow-500 rounded-full p-2">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Under Review</span>
                                    </div>
                                    <span class="text-2xl font-bold text-yellow-600">{{ $statusDistribution->where('status', 'Under Review')->first()->count ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 rounded-full p-2">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Submitted</span>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-600">{{ $statusDistribution->where('status', 'Submitted')->first()->count ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-red-500 rounded-full p-2">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Rejected</span>
                                    </div>
                                    <span class="text-2xl font-bold text-red-600">{{ $statusDistribution->where('status', 'Rejected')->first()->count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Student Insights -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Student Insights</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Programme Distribution -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Programme Distribution</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="programmeChart" height="280"></canvas>
                        </div>
                    </div>

                    <!-- Batch Distribution -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-white">Batch Distribution</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="batchChart" height="280"></canvas>
                        </div>
                    </div>

                    <!-- Document Completion -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-8">
                            <div class="flex items-center justify-center mb-6">
                                <div class="flex-shrink-0 bg-teal-100 rounded-full p-6">
                                    <svg class="h-16 w-16 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-base font-medium text-gray-500 text-center">CV Completion Rate</h4>
                            <p class="text-5xl font-bold text-teal-600 text-center mt-3">{{ $stats['document_completion_rate'] }}%</p>
                            <p class="text-sm text-gray-500 text-center mt-3">Students with uploaded CVs</p>
                        </div>
                    </div>

                    <!-- Students Missing CV -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-8">
                            <div class="flex items-center justify-center mb-6">
                                <div class="flex-shrink-0 bg-red-100 rounded-full p-6">
                                    <svg class="h-16 w-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-base font-medium text-gray-500 text-center">Missing CVs</h4>
                            <p class="text-5xl font-bold text-red-600 text-center mt-3">{{ $stats['students_missing_cv'] }}</p>
                            <p class="text-sm text-gray-500 text-center mt-3">Students need follow-up</p>
                            
                            @if($studentsMissingCVList->count() > 0)
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="space-y-2">
                                        @foreach($studentsMissingCVList as $student)
                                        <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-gray-900 truncate">{{ $student->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $student->cb_number }}</p>
                                            </div>
                                            <a href="{{ route('students.show', $student->id) }}" class="ml-2 text-xs text-red-600 hover:text-red-800 font-medium flex-shrink-0">
                                                View
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Placement Metrics -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Placement Metrics</h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Placement Rate -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex-shrink-0 bg-green-100 rounded-full p-4">
                                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 text-center">Placement Rate</h4>
                            <p class="text-4xl font-bold text-green-600 text-center mt-2">{{ $stats['placement_rate'] }}%</p>
                            <p class="text-xs text-gray-500 text-center mt-2">Students placed successfully</p>
                        </div>
                    </div>

                    <!-- Average Time to Place -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex-shrink-0 bg-purple-100 rounded-full p-4">
                                    <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 text-center">Avg Time to Place</h4>
                            <p class="text-4xl font-bold text-purple-600 text-center mt-2">{{ $stats['avg_time_to_place'] }}</p>
                            <p class="text-xs text-gray-500 text-center mt-2">Days from CV to approval</p>
                        </div>
                    </div>

                    <!-- Companies Not Responding -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex-shrink-0 bg-orange-100 rounded-full p-4">
                                    <svg class="h-10 w-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 text-center">Companies Not Responding</h4>
                            <p class="text-4xl font-bold text-orange-600 text-center mt-2">{{ $stats['companies_not_responding'] }}</p>
                            <p class="text-xs text-gray-500 text-center mt-2">Over 14 days no response</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 5: Company Engagement -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Company Engagement</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Active Companies Metric -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex-shrink-0 bg-blue-100 rounded-full p-4">
                                    <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 text-center">Active Companies</h4>
                            <p class="text-4xl font-bold text-blue-600 text-center mt-2">{{ $stats['active_companies'] }}</p>
                            <p class="text-xs text-gray-500 text-center mt-2">Last 3 months</p>
                        </div>
                    </div>

                    <!-- Industry Distribution -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-base font-semibold text-white">Industry Distribution</h4>
                        </div>
                        <div class="p-6">
                            <canvas id="industryChart" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Position Types -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                        <div class="bg-teal-500 px-6 py-4">
                            <h4 class="text-base font-semibold text-white">Top Positions</h4>
                        </div>
                        <div class="p-6">
                            @if($positionDistribution->count() > 0)
                                <div class="space-y-3">
                                    @foreach($positionDistribution as $position)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700 truncate">{{ $position->position ?? 'N/A' }}</span>
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold bg-teal-100 text-teal-800 rounded-full">{{ $position->count }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm text-center">No position data</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Teal color palette
        const tealColors = {
            primary: '#14b8a6',
            light: '#5eead4',
            dark: '#0f766e',
            gradient: ['#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6']
        };

        // Monthly Trend Chart
        const monthlyCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrends->pluck('month')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($monthlyTrends->pluck('count')) !!},
                    borderColor: tealColors.primary,
                    backgroundColor: 'rgba(20, 184, 166, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: tealColors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Applications: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { 
                            precision: 0,
                            stepSize: 1
                        },
                        grid: {
                            display: true
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.4
                    },
                    point: {
                        radius: 5,
                        hitRadius: 10,
                        hoverRadius: 7
                    }
                }
            }
        });

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusDistribution->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($statusDistribution->pluck('count')) !!},
                    backgroundColor: tealColors.gradient,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Programme Success Chart
        const programmeSuccessCtx = document.getElementById('programmeSuccessChart').getContext('2d');
        new Chart(programmeSuccessCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($successByProgramme->pluck('programme')) !!},
                datasets: [{
                    label: 'Success Rate (%)',
                    data: {!! json_encode($successByProgramme->pluck('success_rate')) !!},
                    backgroundColor: tealColors.gradient,
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Programme Distribution Chart
        const programmeCtx = document.getElementById('programmeChart').getContext('2d');
        new Chart(programmeCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($programmeDistribution->pluck('programme')) !!},
                datasets: [{
                    data: {!! json_encode($programmeDistribution->pluck('count')) !!},
                    backgroundColor: tealColors.gradient,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            font: { size: 11 }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 5
                    }
                }
            }
        });

        // Batch Distribution Chart
        const batchCtx = document.getElementById('batchChart').getContext('2d');
        new Chart(batchCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($batchDistribution->pluck('batch')) !!},
                datasets: [{
                    data: {!! json_encode($batchDistribution->pluck('count')) !!},
                    backgroundColor: tealColors.gradient,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            font: { size: 11 }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 5
                    }
                }
            }
        });

        // Industry Distribution Chart
        const industryCtx = document.getElementById('industryChart').getContext('2d');
        new Chart(industryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($industryDistribution->pluck('industry')) !!},
                datasets: [{
                    label: 'Companies',
                    data: {!! json_encode($industryDistribution->pluck('count')) !!},
                    backgroundColor: tealColors.primary,
                    borderRadius: 8,
                    barThickness: 30
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { 
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        // Top Student Interests Chart
        const interestsCtx = document.getElementById('interestsChart').getContext('2d');
        new Chart(interestsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topInterests->pluck('job_role')) !!},
                datasets: [{
                    label: 'Students',
                    data: {!! json_encode($topInterests->pluck('count')) !!},
                    backgroundColor: tealColors.gradient,
                    borderRadius: 8,
                    barThickness: 35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Students: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
