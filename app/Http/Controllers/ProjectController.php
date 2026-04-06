<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\ActivityLog;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('manager_id', Auth::id())->get();
        return view('manager.dashboard', compact('projects')); 
    }

    public function create()
    {
        return view('manager.create_project'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'Pending',
            'manager_id' => Auth::id(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Created',
            'description' => "Manager created a new project: {$project->name}"
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function destroy(Project $project)
    {
        Task::where('project_id', $project->id)->delete();
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project and its tasks deleted successfully!');
    }

    public function show(Project $project)
    {
        $project->load('tasks.user'); 
        return view('manager.show', compact('project'));
    }
}