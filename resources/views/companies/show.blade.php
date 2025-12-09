<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit Company
                </a>
                <a href="{{ route('companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
    <!-- Page Banner -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-600 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-white text-center">
            <h3 class="text-2xl font-bold">Company Details</h3>
        </div>
    </div>

    <div class="py-6">
        <div class="w-full px-6 space-y-6">
            <!-- Company Information -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    <!-- Company Header with Logo -->
                    <div class="flex items-start space-x-6 mb-6 pb-6 border-b border-gray-200">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            @if($company->logo_url)
                                <img src="{{ $company->logo_url }}" 
                                     alt="{{ $company->name }} logo"
                                     class="h-24 w-24 object-contain rounded-xl bg-gray-50 border border-gray-200 p-3 shadow-sm"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-24 w-24 flex items-center justify-center rounded-xl bg-gray-100 border border-gray-200\'><svg class=\'h-16 w-16 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'></path></svg></div>';">
                            @else
                                <div class="h-24 w-24 flex items-center justify-center rounded-xl bg-gray-100 border border-gray-200">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Company Title & Type -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $company->name }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @if($company->type)
                                    <span class="px-3 py-1 text-sm rounded-full
                                        @if($company->type === 'IT') bg-blue-100 text-blue-800
                                        @elseif($company->type === 'Partner') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $company->type }}
                                    </span>
                                @endif
                                @if($company->industry)
                                    <span class="px-3 py-1 text-sm rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        {{ $company->industry }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Company Details</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($company->description)
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Description</p>
                            <p class="mt-1 text-gray-900">{{ $company->description }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Person</p>
                            <p class="mt-1 text-gray-900">{{ $company->contact_person_name ?? 'N/A' }}</p>
                        </div>

                        @if($company->contact_person_position)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Position</p>
                            <p class="mt-1 text-gray-900">{{ $company->contact_person_position }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Email</p>
                            <p class="mt-1 text-gray-900">
                                <a href="mailto:{{ $company->contact_email }}" class="text-indigo-600 hover:underline">{{ $company->contact_email }}</a>
                            </p>
                        </div>

                        @if($company->contact_phone)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Phone</p>
                            <p class="mt-1 text-gray-900">{{ $company->contact_phone }}</p>
                        </div>
                        @endif

                        @if($company->website)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Website</p>
                            <p class="mt-1 text-gray-900">
                                <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $company->website }}</a>
                            </p>
                        </div>
                        @endif

                        @if($company->address)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1 text-gray-900">{{ $company->address }}</p>
                        </div>
                        @endif

                        @if($company->city)
                        <div>
                            <p class="text-sm font-medium text-gray-500">City</p>
                            <p class="mt-1 text-gray-900">{{ $company->city }}</p>
                        </div>
                        @endif

                        @if($company->country)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Country</p>
                            <p class="mt-1 text-gray-900">{{ $company->country }}</p>
                        </div>
                        @endif

                        @if($company->notes)
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Notes</p>
                            <p class="mt-1 text-gray-900">{{ $company->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Applications</p>
                                <p class="mt-2 text-3xl font-bold text-teal-600">{{ $company->applications()->count() }}</p>
                            </div>
                            <div class="h-12 w-12 bg-teal-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Approved</p>
                                <p class="mt-2 text-3xl font-bold text-green-600">{{ $company->applications()->where('status', 'Approved')->count() }}</p>
                            </div>
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">In Progress</p>
                                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $company->applications()->whereIn('status', ['Shortlisted', 'Interview'])->count() }}</p>
                            </div>
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Approval Rate</p>
                                @php
                                    $total = $company->applications()->count();
                                    $approved = $company->applications()->where('status', 'Approved')->count();
                                    $rate = $total > 0 ? round(($approved / $total) * 100) : 0;
                                @endphp
                                <p class="mt-2 text-3xl font-bold text-purple-600">{{ $rate }}%</p>
                            </div>
                            <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Application Status Breakdown -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="bg-teal-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                            Application Status Breakdown
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="statusChart" height="250"></canvas>
                    </div>
                </div>

                <!-- Applications by Programme -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                    <div class="bg-teal-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Applications by Programme
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="programmeChart" height="250"></canvas>
                    </div>
                </div>

                <!-- Monthly Application Trend -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200 lg:col-span-2">
                    <div class="bg-teal-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                            Monthly Application Trend (Last 6 Months)
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="trendChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="bg-teal-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Students Who Applied ({{ $company->applications->count() }})
                    </h3>
                </div>
                <div class="p-6">
                    @if($company->applications->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programme</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opportunity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interests</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($company->applications as $application)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-teal-100 rounded-full flex items-center justify-center">
                                                <span class="text-teal-600 font-semibold">{{ substr($application->student->name, 0, 2) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $application->student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->student->student_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->student->programme }}</td>
                                    <td class="px-6 py-4">
                                        @if($application->opportunityAnnouncement)
                                            <div class="text-sm text-gray-900">
                                                @if(!empty($application->opportunityAnnouncement->roles))
                                                    {{ implode(', ', $application->opportunityAnnouncement->roles) }}
                                                @else
                                                    {{ $application->position ?? 'N/A' }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Announced: {{ $application->opportunityAnnouncement->announced_at->format('M j, Y') }}
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">Direct Application</div>
                                            <div class="text-xs text-gray-400">{{ $application->position ?? 'N/A' }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($application->student->interests->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($application->student->interests->take(2) as $interest)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $interest->job_role }}
                                                    </span>
                                                @endforeach
                                                @if($application->student->interests->count() > 2)
                                                    <span class="text-xs text-gray-500">+{{ $application->student->interests->count() - 2 }} more</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">No interests</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $application->status == 'Approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $application->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $application->status == 'Pending' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $application->status == 'CV Sent' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $application->status == 'Shortlisted' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $application->status == 'Interview' ? 'bg-purple-100 text-purple-800' : '' }}">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $application->created_at->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium space-x-3">
                                        <a href="{{ route('applications.show', $application) }}" class="inline-flex items-center px-3 py-1 bg-teal-500 border border-transparent rounded-lg font-semibold text-xs text-white hover:bg-teal-600 transition-all">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Application
                                        </a>
                                        <a href="{{ route('students.show', $application->student) }}" class="inline-flex items-center px-3 py-1 bg-gray-500 border border-transparent rounded-lg font-semibold text-xs text-white hover:bg-gray-600 transition-all">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Student Profile
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No applications yet</h3>
                        <p class="mt-2 text-sm text-gray-500">No students have applied to this company.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Prepare data for charts
        @php
            // Status breakdown data
            $statusCounts = $company->applications->groupBy('status')->map->count();
            
            // Programme breakdown data
            $programmeCounts = $company->applications->groupBy(function($app) {
                return $app->student->programme;
            })->map->count()->sortDesc()->take(5);
            
            // Monthly trend data (last 6 months)
            $monthlyData = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $count = $company->applications()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                $monthlyData[$month->format('M Y')] = $count;
            }
        @endphp

        // Status Breakdown Doughnut Chart
        const statusCtx = document.getElementById('statusChart');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusCounts->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusCounts->values()) !!},
                    backgroundColor: [
                        'rgba(156, 163, 175, 0.9)', // Pending - Gray
                        'rgba(59, 130, 246, 0.9)',   // CV Sent - Blue
                        'rgba(251, 191, 36, 0.9)',   // Shortlisted - Yellow
                        'rgba(168, 85, 247, 0.9)',   // Interview - Purple
                        'rgba(34, 197, 94, 0.9)',    // Approved - Green
                        'rgba(239, 68, 68, 0.9)',    // Rejected - Red
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8,
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    animateScale: false
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 13,
                                family: "'Inter', sans-serif"
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            boxHeight: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Programme Bar Chart
        const programmeCtx = document.getElementById('programmeChart');
        new Chart(programmeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($programmeCounts->keys()) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($programmeCounts->values()) !!},
                    backgroundColor: 'rgba(20, 184, 166, 0.85)',
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: 'rgba(20, 184, 166, 1)',
                    barThickness: 32
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return 'Applications: ' + context.parsed.x;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Monthly Trend Line Chart
        const trendCtx = document.getElementById('trendChart');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($monthlyData)) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode(array_values($monthlyData)) !!},
                    backgroundColor: function(context) {
                        const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 200);
                        gradient.addColorStop(0, 'rgba(20, 184, 166, 0.3)');
                        gradient.addColorStop(1, 'rgba(20, 184, 166, 0)');
                        return gradient;
                    },
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(20, 184, 166)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        mode: 'index',
                        intersect: false,
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
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
