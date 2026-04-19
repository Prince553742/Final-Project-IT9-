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
        $projects = Project::withCount([
            'tasks as pending_tasks_count' => function ($query) {
                $query->where('status', '!=', 'Completed');
            },
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'Completed');
            }
        ])->get();

        $recentActivities = ActivityLog::with('user')
            ->whereHas('task.project', function($q) {
                $q->where('manager_id', Auth::id());
            })
            ->orWhere('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('manager.dashboard', compact('projects', 'recentActivities'));
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

        $project = Project::create([
            'name' => $request->title, 
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
        if ($project->manager_id !== Auth::id()) {
            abort(403);
        }

        $projectName = $project->name; 
        $project->delete();

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


    public function editProject(Project $project)
    {
        // Security: ensure the logged-in manager owns this project
        if ($project->manager_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('manager.edit_project', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        // Security check
        if ($project->manager_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Updated',
            'description' => "Manager updated project: {$project->name}"
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Project updated successfully!');
    }
}

