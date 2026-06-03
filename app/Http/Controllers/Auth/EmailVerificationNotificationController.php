<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role == 'guru') {
            return redirect('/guru/dashboard');
        } else {
            return redirect('/siswa/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
