<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TaskActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $logs = ActivityLog::with('user')->latest();

        if ($role === 'Team Member') {
            $logs = $logs->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('task', function($taskQuery) use ($user) {
                      $taskQuery->where('assigned_user_id', $user->id);
                  });
            });
        } elseif ($role === 'Manager') {
            $logs = $logs->whereHas('task.project', function($q) use ($user) {
                $q->where('manager_id', $user->id);
            })->orWhere('user_id', $user->id);
        }

        $logs = $logs->paginate(20);

        return view('activities.activity', compact('logs'));
    }
}