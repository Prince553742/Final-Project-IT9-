<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskComment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // MANAGER: Show Create Form
    public function create(Request $request)
    {
        $projectId = $request->query('project_id');
        $users = User::where('role', 'Team Member')->get();
        return view('manager.create_task', compact('projectId', 'users'));
    }
    
    // MANAGER: Store Task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'       => 'required|exists:projects,id',
            'title'            => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'required|in:Low,Medium,High,Urgent',
            'due_date'         => 'required|date',
            'description'      => 'nullable|string',
        ]);

        $validated['status'] = 'Pending'; 
        $validated['created_by'] = Auth::id(); 

        $task = Task::create($validated);

        ActivityLog::create([
            'task_id'     => $task->id,
            'user_id'     => Auth::id(),
            'action'      => 'Task Created',
            'description' => "Assigned task '{$task->title}' to a team member."
        ]);
        
        return redirect()->route('projects.show', $request->project_id)
                         ->with('success', 'Task successfully assigned!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        if ($task->isCompleted()) {
            return redirect()->back()->with('error', 'Completed or cancelled tasks cannot be edited.');
        }

        $users = User::where('role', 'Team Member')->get();
        return view('manager.edit_task', compact('task', 'users'));
    }

    public function update(Request $request, $id)
    {

        $task = Task::findOrFail($id);
    
        if ($task->isCompleted()) {
            return redirect()->back()->with('error', 'Completed or cancelled tasks cannot be updated.');
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'required|in:Low,Medium,High,Urgent',
            'due_date'         => 'required|date',
            'description'      => 'nullable|string',
            'status'           => 'required|in:Pending,In Progress,On Hold,Completed,Cancelled'
        ]);

        $task->update($validated);

        ActivityLog::create([
            'task_id'     => $task->id,
            'user_id'     => Auth::id(),
            'action'      => 'Task Updated',
            'description' => "Updated details for task '{$task->title}'."
        ]);

        return redirect()->route('projects.show', $task->project_id)
                         ->with('success', 'Task successfully updated!');
    }

    // MANAGER: Delete Task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $projectId = $task->project_id;
        
        $task->delete();

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Task successfully deleted!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,On Hold,Completed,Cancelled'
        ]);

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        ActivityLog::create([
            'task_id'     => $task->id,
            'user_id'     => Auth::id(),
            'action'      => 'Status Update',
            'description' => "Changed status from {$oldStatus} to {$request->status}"
        ]);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }

    public function storeComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        ActivityLog::create([
            'task_id'     => $task->id,
            'user_id'     => Auth::id(),
            'action'      => 'Added Comment',
            'description' => "Added a comment to the task."
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function memberDashboard()
    {
        $userId = Auth::id(); 
        
        $stats = [
            'active'    => Task::where('assigned_user_id', $userId)
                            ->whereNotIn('status', ['Completed', 'Cancelled'])->count(),
            'completed' => Task::where('assigned_user_id', $userId)
                            ->where('status', 'Completed')->count(),
            'urgent'    => Task::where('assigned_user_id', $userId)
                            ->whereNotIn('status', ['Completed', 'Cancelled'])
                            ->where('due_date', '<=', now()->addDays(3))->count(),
        ];

        $upcomingTasks = Task::where('assigned_user_id', $userId)   
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->orderBy('due_date', 'asc')->take(5)->get();

        // Recent activity (tasks assigned to this member or actions by the member)
        $recentActivities = ActivityLog::with('user')
            ->where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhereHas('task', function($taskQuery) use ($userId) {
                    $taskQuery->where('assigned_user_id', $userId);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('member.dashboard', compact('stats', 'upcomingTasks', 'recentActivities'));     
    }

    public function myTasks(Request $request)
    {
        $isHistory = $request->is('*history*');
        $query = Task::where('assigned_user_id', Auth::id())->with('project');

        if ($isHistory) {
            $tasks = $query->whereIn('status', ['Completed', 'Cancelled'])->latest()->get();
            $pageTitle = "Task History";
        } else {
            $tasks = $query->whereNotIn('status', ['Completed', 'Cancelled'])->latest()->get();
            $pageTitle = "Active Tasks";
        }

        return view('member.tasks_list', compact('tasks', 'pageTitle', 'isHistory'));
    }

    public function show(Task $task)
    {
        $task->load(['project', 'assignedUser', 'comments.user']);
        return view('tasks.show', compact('task'));
    }

}