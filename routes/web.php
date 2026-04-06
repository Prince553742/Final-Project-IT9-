<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ManagerController;

Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATED ROUTES ---
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

    Route::get('/system-dashboard', [DashboardController::class, 'index'])->name('system.dashboard');

    // Task Actions (Status, Edit, Delete)
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show'); // Moved inside prefix
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('update-status');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::post('/{task}/comments', [TaskController::class, 'storeComment'])->name('comments.store');
    });
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('admin.panel');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');   
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::patch('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// --- MANAGER ROUTES ---
Route::middleware(['auth', 'role:Manager'])->group(function () {
    Route::get('/manager', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/team', [DashboardController::class, 'team'])->name('manager.team');
    Route::get('/manager/team/{user}/workload', [DashboardController::class, 'viewWorkload'])->name('manager.team.workload');  
    Route::get('/manager/activity', [ManagerController::class, 'activity'])->name('manager.activity'); 
    
    // Project Management
    Route::get('/manager/projects/create', [ManagerController::class, 'createProject'])->name('manager.projects.create');
    Route::post('/manager/projects', [ManagerController::class, 'storeProject'])->name('manager.projects.store');
    
    // This name "projects.show" is used by TaskController to redirect after saving a task
    Route::get('/manager/projects/{project}', [ManagerController::class, 'showProject'])->name('projects.show'); 
    
    Route::delete('/manager/projects/{project}', [ManagerController::class, 'destroyProject'])->name('manager.projects.destroy');
    
    // Task Assignment
    Route::get('/manager/tasks/create', [TaskController::class, 'create'])->name('manager.tasks.create');
    Route::post('/manager/tasks', [TaskController::class, 'store'])->name('manager.tasks.store');
});

// --- TEAM MEMBER ROUTES ---
Route::middleware(['auth', 'role:Team Member'])->group(function () {
    Route::get('/member', [TaskController::class, 'memberDashboard'])->name('member.dashboard');
    Route::get('/member/tasks', [TaskController::class, 'myTasks'])->name('member.tasks');
    Route::get('/member/history', [TaskController::class, 'myTasks'])->name('member.history');    
    Route::get('/member/activity', [TaskController::class, 'teamActivity'])->name('member.activity');
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