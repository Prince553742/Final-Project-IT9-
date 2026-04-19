<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskActivityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATED ROUTES (Shared) ---
Route::middleware(['auth'])->group(function () {
    
    // Role-based Redirect Dashboard
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'Manager') {
            return redirect()->route('manager.dashboard');
        } else {
            return redirect()->route('member.dashboard');
        }
    })->name('dashboard');

    // Centralized Task View & Logic
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::put('/{task}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
        
        // --- Separated Comment Controller ---
        Route::post('/{task}/comments', [TaskCommentController::class, 'store'])->name('comments.store');
    });

    // --- Shared Reports Access ---
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // --- Shared Activity Feed ---
    Route::get('/activities', [TaskActivityController::class, 'index'])->name('activities.index');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('admin.panel');
    
    // Direct activity log view (no redirect)
    Route::get('/admin/logs', [TaskActivityController::class, 'index'])->name('admin.logs');
    
    // System-wide Management
    Route::patch('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    
    // Redirect old report route to shared reports page
    Route::get('/admin/reports', fn() => redirect()->route('reports.index'));

    // Admin Task Edit & Update
    Route::get('/admin/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('admin.tasks.edit');
    Route::put('/admin/tasks/{task}', [AdminController::class, 'updateTask'])->name('admin.tasks.update');

    // Admin Project Management
    Route::get('/admin/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::get('/admin/projects/{project}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
    Route::put('/admin/projects/{project}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [AdminController::class, 'destroyProject'])->name('admin.projects.destroy');

    // Admin Task Management
    Route::get('/admin/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');
    Route::delete('/admin/tasks/{task}', [AdminController::class, 'destroyTask'])->name('admin.tasks.destroy');
});

// --- MANAGER ROUTES ---
Route::middleware(['auth', 'role:Manager'])->group(function () {
    Route::get('/manager', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/activity', [TaskActivityController::class, 'index'])->name('manager.activity');
    
    // Team & Workload
    Route::get('/manager/team', [DashboardController::class, 'team'])->name('manager.team');
    Route::get('/manager/team/{user}/workload', [DashboardController::class, 'viewWorkload'])->name('manager.team.workload');  

    // Project Management
    Route::get('/manager/projects/create', [ManagerController::class, 'createProject'])->name('manager.projects.create');
    Route::post('/manager/projects', [ManagerController::class, 'storeProject'])->name('manager.projects.store');
    Route::get('/manager/projects/{project}', [ManagerController::class, 'showProject'])->name('projects.show'); 
    Route::delete('/manager/projects/{project}', [ManagerController::class, 'destroyProject'])->name('manager.projects.destroy');
    
    // Edit Project Routes
    Route::get('/manager/projects/{project}/edit', [ManagerController::class, 'editProject'])->name('manager.projects.edit');
    Route::put('/manager/projects/{project}', [ManagerController::class, 'updateProject'])->name('manager.projects.update');
    
    // Task Management
    Route::get('/manager/tasks/create', [TaskController::class, 'create'])->name('manager.tasks.create');
    Route::post('/manager/tasks', [TaskController::class, 'store'])->name('manager.tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

// --- TEAM MEMBER ROUTES ---
Route::middleware(['auth', 'role:Team Member'])->group(function () {
    Route::get('/member', [TaskController::class, 'memberDashboard'])->name('member.dashboard');
    Route::get('/member/tasks', [TaskController::class, 'myTasks'])->name('member.tasks');
    Route::get('/member/history', [TaskController::class, 'myTasks'])->name('member.history');    
    Route::get('/member/activity', [TaskActivityController::class, 'index'])->name('member.activity');
});

// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- LOGOUT ---
Route::get('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

require __DIR__.'/auth.php';