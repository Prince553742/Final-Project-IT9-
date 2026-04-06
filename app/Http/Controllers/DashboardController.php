<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\User; 
use App\Models\Task; 


class DashboardController extends Controller
{
    public function team()
    {
        $teamMembers = \App\Models\User::where('role', 'Team Member')
            ->withCount(['tasks' => function ($query) {
                $query->where('status', 'Pending');
            }])
            ->get();

        return view('manager.team', compact('teamMembers'));
    }

    public function index()
    {
        $projects = Project::all(); 

        return view('manager.dashboard', compact('projects'));    
    }

// Inside App\Http\Controllers\DashboardController.php

    public function viewWorkload(User $user)
    {
        // Fetch the user's tasks with their projects
        $tasks = Task::where('assigned_user_id', $user->id)
                    ->with('project')
                    ->latest()
                    ->get();

        return view('manager.workload', compact('user', 'tasks'));
    }
}