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
        $projects = Project::where('manager_id', Auth::id())
            ->withCount([
                'tasks as pending_tasks_count' => function ($query) {
                    $query->where('status', '!=', 'Completed');
                },
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'Completed');
                }
            ])
            ->get();

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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'priority'    => 'required|in:Low,Medium,High,Urgent',
            'status'      => 'required|in:Pending,Active,On Hold,Completed,Cancelled',
        ]);

        $project = Project::create([
            'name'        => $request->title,
            'description' => $request->description,
            'manager_id'  => Auth::id(),
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
            'status'      => $request->status,
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
        $users = User::where('role', 'Team Member')->get();
        return view('manager.create_task', compact('project', 'users'));
    }

    public function storeTask(Request $request, Project $project)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'required|in:Low,Medium,High,Urgent',
            'due_date'         => 'required|date',
            'description'      => 'nullable|string',
        ]);

        $task = Task::create([
            'project_id'       => $project->id,
            'title'            => $request->title,
            'description'      => $request->description,
            'assigned_user_id' => $request->assigned_user_id,
            'priority'         => $request->priority,
            'due_date'         => $request->due_date,
            'status'           => 'Pending',
            'created_by'       => Auth::id(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Assigned',
            'description' => "Assigned '{$task->title}' to " . ($task->assignedUser->name ?? 'a team member')
        ]);

        return redirect()->route('projects.show', $project->id)
                         ->with('success', 'Task assigned successfully!');
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
        if ($project->manager_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('manager.edit_project', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        if ($project->manager_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'priority'    => 'required|in:Low,Medium,High,Urgent',
            'status'      => 'required|in:Pending,Active,On Hold,Completed,Cancelled',
        ]);

        $project->update([
            'name'        => $request->name,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
            'status'      => $request->status,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Updated',
            'description' => "Manager updated project: {$project->name}"
        ]);

        return redirect()->route('manager.dashboard')->with('success', 'Project updated successfully!');
    }
}