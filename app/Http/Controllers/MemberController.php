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
}