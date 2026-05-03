<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project; 
use App\Models\Task;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Exports\TasksExport;
use App\Exports\ProjectsExport;
use App\Exports\TaskStatusSummaryExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function tasks(Request $request)
    {
        $query = Task::with('project', 'assignedUser');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->latest()->paginate(10)->appends($request->query());

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

    public function exportTasksExcel()
    {
        return Excel::download(new TasksExport, 'tasks.xlsx');
    }

    public function exportTasksPdf()
    {
        $tasks = Task::with('project', 'assignedUser')->get();
        $pdf = Pdf::loadView('exports.tasks_pdf', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }

    public function exportProjectsExcel()
    {
        return Excel::download(new ProjectsExport, 'projects.xlsx');
    }

    public function exportProjectsPdf()
    {
        $projects = Project::with('manager')->withCount('tasks')->get();
        $pdf = Pdf::loadView('exports.projects_pdf', compact('projects'));
        return $pdf->download('projects.pdf');
    }

    public function exportTaskStatusExcel()
    {
        return Excel::download(new TaskStatusSummaryExport, 'task_status_summary.xlsx');
    }

    public function exportTaskStatusPdf()
    {
        $statuses = [
            'Pending' => Task::where('status', 'Pending')->count(),
            'In Progress' => Task::where('status', 'In Progress')->count(),
            'On Hold' => Task::where('status', 'On Hold')->count(),
            'Completed' => Task::where('status', 'Completed')->count(),
            'Cancelled' => Task::where('status', 'Cancelled')->count(),
        ];
        $pdf = Pdf::loadView('exports.task_status_pdf', compact('statuses'));
        return $pdf->download('task_status_summary.pdf');
    }
}