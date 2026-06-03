<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectByRole($user);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectByRole($user);
    }

    private function redirectByRole($user)
    {
        if ($user->role == 'admin') {
            return redirect('/admin/dashboard?verified=1');
        } elseif ($user->role == 'guru') {
            return redirect('/guru/dashboard?verified=1');
        } else {
            return redirect('/siswa/dashboard?verified=1');
        }
    }
}
