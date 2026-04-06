<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\ActivityLog;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Logged In',
            'description' => 'User signed in successfully.'
        ]);

        $user = Auth::user();
        
        if ($user->role === 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'Manager') {
            return redirect()->intended(route('manager.dashboard'));        
        } elseif ($user->role === 'Team Member') {
            return redirect()->intended(route('member.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Logged Out',
                'description' => 'User securely signed out.'
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}