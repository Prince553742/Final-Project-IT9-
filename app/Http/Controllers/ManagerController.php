<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function dashboard()
    {
        // Temporarily remove the where('manager_id', Auth::id()) to confirm the project exists
        $projects = Project::withCount([
                'tasks as pending_tasks_count' => function ($query) {
                    $query->where('status', '!=', 'Completed');
                },
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'Completed');
                }
            ])
            ->get();

        return view('manager.dashboard', compact('projects'));
    }
    
    public function createProject()
    {
        return view('manager.create_project');
    }


    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Ensure the key matches 'name' in the Project::create array
        $project = Project::create([
            'name' => $request->title, // 'name' is the database column, 'title' is your form input
            'description' => $request->description,
            'manager_id' => Auth::id(),
            'due_date' => now()->addDays(30), 
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Created',
            'description' => "Manager created project: {$project->name}"
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Project created!');
    }

    public function createTask(Project $project)
    {
        $users = \App\Models\User::where('role', 'Team Member')->get();

        return view('manager.create_task', compact('project', 'users'));
    }


    public function storeTask(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'deadline' => 'required|date',        
        ]);

        $task = Task::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'assigned_user_id' => $request->assigned_to,
            'status' => 'Pending',
            'due_date' => $request->deadline,
            'created_by' => Auth::id(), 
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Assigned',
            'description' => "Assigned '{$task->title}' to " . $task->assignedUser->name
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Task assigned successfully!');
    }

    public function destroyProject(Project $project)
    {
        // Security check
        if ($project->manager_id !== Auth::id()) {
            abort(403);
        }

        $projectName = $project->name; 
        $project->delete();

        // Record in System Logs
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Deleted',
            'description' => "Manager deleted project: {$projectName}"
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Project deleted successfully!');
    }

    public function showProject(Project $project)
    {
        $project->load('tasks.assignedUser');

        return view('manager.show_project', compact('project'));
    }
    
    public function activity()
    {
        $logs = \App\Models\ActivityLog::with('user')->latest()->get();

        return view('manager.activity', compact('logs'));
    }
}