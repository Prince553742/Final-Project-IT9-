<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $tasks = Task::where('assigned_user_id', Auth::id())
                    ->with('project') 
                    ->get();

        return view('member.dashboard', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Task status updated!');
    }
}