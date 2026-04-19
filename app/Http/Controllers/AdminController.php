<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project; 
use App\Models\Task;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        
        $completedTasks = Task::where('status', 'Completed')->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $overallProgress = $completionRate;
        $overdueTasks = Task::where('due_date', '<', now())
                            ->where('status', '!=', 'Completed')
                            ->count();

        $totalAdmins = User::where('role', 'Admin')->count();
        $totalManagers = User::where('role', 'Manager')->count();
        $totalMembers = User::where('role', 'Team Member')->count();

        $topProjects = Project::withCount('tasks')
                            ->orderBy('tasks_count', 'desc')
                            ->take(5)
                            ->get();

        // Removed redundant queries: $recentTasks, $upcomingTasks, $recentActivities
        // They are not used in the current admin dashboard.

        return view('admin.dashboard', compact(
            'users',
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'completionRate',
            'overallProgress',
            'overdueTasks',
            'totalAdmins',
            'totalManagers',
            'totalMembers',
            'topProjects'
        ));
    }

    public function panel()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.panel', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:Admin,Manager,Team Member'
        ]);

        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Role Updated',
            'description' => "Changed {$user->name}'s role from {$oldRole} to {$request->role}."
        ]);

        return back()->with('status', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'User Deleted',
            'description' => "Deleted user account: {$name}."
        ]);

        return back()->with('status', 'User deleted successfully!');
    }

    // Project Management (Admin)
    public function projects()
    {
        $projects = Project::with('manager')->withCount('tasks')->latest()->paginate(10);
        return view('admin.projects', compact('projects'));
    }

    public function editProject(Project $project)
    {
        $managers = User::where('role', 'Manager')->get();
        return view('admin.edit_project', compact('project', 'managers'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'manager_id' => 'required|exists:users,id',
        ]);

        $project->update($request->only(['name', 'description', 'due_date', 'manager_id']));

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Updated',
            'description' => "Admin updated project: {$project->name}"
        ]);

        return redirect()->route('admin.projects')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        $projectName = $project->name;
        $project->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Deleted',
            'description' => "Admin deleted project: {$projectName}"
        ]);

        return redirect()->route('admin.projects')->with('success', 'Project deleted successfully.');
    }

    // Task Management (Admin)
    public function tasks()
    {
        $tasks = Task::with('project', 'assignedUser')->latest()->paginate(10);
        return view('admin.tasks', compact('tasks'));
    }

    public function destroyTask(Task $task)
    {
        $taskTitle = $task->title;
        $task->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Deleted',
            'description' => "Admin deleted task: {$taskTitle}"
        ]);

        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully.');
    }

    public function editTask(Task $task)
    {
        $users = User::all();
        return view('admin.edit_task', compact('task', 'users'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'required|exists:users,id',
            'priority' => 'required|in:Low,Medium,High,Urgent',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,On Hold,Completed,Cancelled'
        ]);

        $task->update($request->only(['title', 'description', 'assigned_user_id', 'priority', 'due_date', 'status']));

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Updated',
            'description' => "Admin updated task: {$task->title}"
        ]);

        return redirect()->route('admin.tasks')->with('success', 'Task updated successfully.');
    }
}