<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'Admin')->count();
        $managerCount = User::where('role', 'Manager')->count();
        $memberCount = User::where('role', 'Team Member')->count();

        $totalLogs = ActivityLog::count();
        $recentLogins = ActivityLog::where('action', 'Logged In')
                            ->where('created_at', '>=', Carbon::now()->subDays(7))
                            ->count();

        $taskStatuses = [
            'Pending' => Task::where('status', 'Pending')->count(),
            'In Progress' => Task::where('status', 'In Progress')->count(),
            'On Hold' => Task::where('status', 'On Hold')->count(),
            'Completed' => Task::where('status', 'Completed')->count(),
            'Cancelled' => Task::where('status', 'Cancelled')->count(),
        ];

        $topProjects = Project::withCount('tasks')
                            ->orderBy('tasks_count', 'desc')
                            ->take(5)
                            ->get();
        $projectNames = $topProjects->pluck('name');
        $projectTaskCounts = $topProjects->pluck('tasks_count');

        $overdueTasks = Task::where('due_date', '<', Carbon::now())
                            ->where('status', '!=', 'Completed')
                            ->count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $totalTasks = Task::count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // NEW: User Productivity Summary
        $userProductivity = User::withCount(['tasks as total_tasks'])
            ->withCount(['tasks as completed_tasks' => function($q) {
                $q->where('status', 'Completed');
            }])
            ->get();

        return view('reports.index', compact(
            'totalUsers', 'adminCount', 'managerCount', 'memberCount',
            'totalLogs', 'recentLogins', 'taskStatuses', 'projectNames',
            'projectTaskCounts', 'overdueTasks', 'completedTasks',
            'totalTasks', 'completionRate', 'userProductivity'
        ));
    }
}