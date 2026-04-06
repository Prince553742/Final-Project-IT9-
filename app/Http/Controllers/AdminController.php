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
        $progressPercent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return view('admin.dashboard', compact('users', 'totalProjects', 'totalTasks', 'progressPercent'));
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

        // Security: Don't let Admin delete themselves
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

    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->get();

        return view('admin.logs', compact('logs'));
    }

    public function reports()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'Admin')->count();
        $managerCount = User::where('role', 'Manager')->count();
        $memberCount = User::where('role', 'Team Member')->count();
        
        $totalLogs = ActivityLog::count();
        $recentLogins = ActivityLog::where('action', 'Logged In')
                                    ->where('created_at', '>=', now()->subDays(7))
                                    ->count();

        return view('admin.reports', compact(
            'totalUsers', 'adminCount', 'managerCount', 'memberCount', 'totalLogs', 'recentLogins'
        ));
    }
}