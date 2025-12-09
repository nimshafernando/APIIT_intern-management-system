<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Company;
use App\Models\Application;
use App\Models\StudentDocument;
use App\Models\WorkLog;
use App\Models\StudentInterest;
use App\Models\OpportunityAnnouncement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $totalStudents = Student::count();
        $totalCompanies = Company::count();
        $totalApplications = Application::count();
        $approvedApplications = Application::where('status', 'Approved')->count();
        $pendingApplications = Application::whereIn('status', ['Submitted', 'Under Review'])->count();
        $rejectedApplications = Application::where('status', 'Rejected')->count();
        $activePlacements = Application::where('status', 'Approved')->count();
        $approvalRate = $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 1) : 0;

        // Application Status Distribution
        $statusDistribution = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Monthly Application Trends (Last 6 Months)
        $monthlyTrends = Application::select(
                DB::raw('DATE_FORMAT(sent_date, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('sent_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top Companies by Applications
        $topCompanies = Company::withCount('applications')
            ->orderBy('applications_count', 'desc')
            ->take(5)
            ->get();

        // Programme Distribution
        $programmeDistribution = Student::select('programme', DB::raw('count(*) as count'))
            ->groupBy('programme')
            ->get();

        // Batch Distribution
        $batchDistribution = Student::select('batch', DB::raw('count(*) as count'))
            ->groupBy('batch')
            ->orderBy('batch', 'desc')
            ->take(5)
            ->get();

        // Document Completion Rate
        $studentsWithCV = Student::whereHas('documents', function($query) {
            $query->whereHas('documentType', function($q) {
                $q->where('name', 'CVs');
            });
        })->count();
        $documentCompletionRate = $totalStudents > 0 ? round(($studentsWithCV / $totalStudents) * 100, 1) : 0;

        // Active Companies (with applications in last 3 months)
        $activeCompanies = Company::whereHas('applications', function($query) {
            $query->where('sent_date', '>=', Carbon::now()->subMonths(3));
        })->count();

        // Industry Distribution
        $industryDistribution = Company::select('industry', DB::raw('count(*) as count'))
            ->whereNotNull('industry')
            ->groupBy('industry')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Position Types Distribution
        $positionDistribution = Application::select('position', DB::raw('count(*) as count'))
            ->whereNotNull('position')
            ->groupBy('position')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Recent Applications
        $recentApplications = Application::with(['student', 'company'])
            ->latest()
            ->take(10)
            ->get();

        // Applications Needing Review (Under Review for more than 7 days)
        $reviewAlerts = Application::where('status', 'Under Review')
            ->where('sent_date', '<', Carbon::now()->subDays(7))
            ->count();

        // Students Missing CVs
        $studentsMissingCV = Student::whereDoesntHave('documents', function($query) {
            $query->whereHas('documentType', function($q) {
                $q->where('name', 'CVs');
            });
        })->count();

        // Get detailed list of students missing CVs
        $studentsMissingCVList = Student::whereDoesntHave('documents', function($query) {
            $query->whereHas('documentType', function($q) {
                $q->where('name', 'CVs');
            });
        })->orderBy('name')->get();

        // Internship Placement Rate
        $eligibleStudents = Student::count(); // All students are eligible
        $placedStudents = Application::where('status', 'Approved')->distinct('student_id')->count('student_id');
        $placementRate = $eligibleStudents > 0 ? round(($placedStudents / $eligibleStudents) * 100, 1) : 0;

        // Average Time to Place a Student (CV sent to Approved)
        $avgTimeToPlace = Application::where('status', 'Approved')
            ->whereNotNull('sent_date')
            ->whereNotNull('updated_at')
            ->selectRaw('AVG(DATEDIFF(updated_at, sent_date)) as avg_days')
            ->value('avg_days');
        $avgTimeToPlace = $avgTimeToPlace ? round($avgTimeToPlace, 1) : 0;

        // Weekly Activity Summary
        $weeklyApplications = Application::whereBetween('sent_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        
        // Monthly Activity Summary
        $monthlyApplications = Application::whereBetween('sent_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // Companies Not Responding (Under Review for more than 14 days)
        $companiesNotResponding = Company::whereHas('applications', function($query) {
            $query->where('status', 'Under Review')
                  ->where('sent_date', '<', Carbon::now()->subDays(14));
        })->distinct()->count();

        // Top Student Interest Areas
        $topInterests = StudentInterest::select('job_role', DB::raw('count(*) as count'))
            ->groupBy('job_role')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // Applications This Week vs Last Week
        $thisWeekApplications = Application::whereBetween('sent_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        
        $lastWeekApplications = Application::whereBetween('sent_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();

        // Weekly Approvals (current week vs last week)
        $currentWeekApprovals = Application::where('status', 'Approved')
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        
        $lastWeekApprovals = Application::where('status', 'Approved')
            ->whereBetween('updated_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();

        // Success Rate by Programme
        $successByProgramme = Student::select('students.programme')
            ->leftJoin('applications', 'students.id', '=', 'applications.student_id')
            ->selectRaw('students.programme, 
                COUNT(applications.id) as total_apps,
                SUM(CASE WHEN applications.status = "Approved" THEN 1 ELSE 0 END) as approved')
            ->groupBy('students.programme')
            ->get()
            ->map(function($item) {
                $item->success_rate = $item->total_apps > 0 
                    ? round(($item->approved / $item->total_apps) * 100, 1) 
                    : 0;
                return $item;
            });

        $stats = [
            'total_students' => $totalStudents,
            'total_companies' => $totalCompanies,
            'total_applications' => $totalApplications,
            'approval_rate' => $approvalRate,
            'rejected_applications' => $rejectedApplications,
            'active_placements' => $activePlacements,
            'document_completion_rate' => $documentCompletionRate,
            'active_companies' => $activeCompanies,
            'review_alerts' => $reviewAlerts,
            'students_missing_cv' => $studentsMissingCV,
            'current_week_approvals' => $currentWeekApprovals,
            'last_week_approvals' => $lastWeekApprovals,
            'placement_rate' => $placementRate,
            'avg_time_to_place' => $avgTimeToPlace,
            'weekly_applications' => $weeklyApplications,
            'monthly_applications' => $monthlyApplications,
            'companies_not_responding' => $companiesNotResponding,
            'this_week_applications' => $thisWeekApplications,
            'last_week_applications' => $lastWeekApplications,
        ];

        // Opportunity Announcements - Closing Soon (deadline within 7 days)
        $closingSoonOpportunities = OpportunityAnnouncement::with('company')
            ->where('status', 'Open')
            ->whereBetween('deadline', [now(), now()->addDays(7)])
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();

        // New Opportunities This Week
        $newThisWeekOpportunities = OpportunityAnnouncement::with('company')
            ->where('announced_at', '>=', now()->subDays(7))
            ->orderBy('announced_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'statusDistribution',
            'monthlyTrends',
            'topCompanies',
            'programmeDistribution',
            'batchDistribution',
            'industryDistribution',
            'positionDistribution',
            'recentApplications',
            'successByProgramme',
            'studentsMissingCVList',
            'topInterests',
            'closingSoonOpportunities',
            'newThisWeekOpportunities'
        ));
    }
}
