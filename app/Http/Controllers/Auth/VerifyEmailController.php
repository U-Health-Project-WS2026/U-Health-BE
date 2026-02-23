<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(int $id, string $hash)
    {
        $user = User::findOrFail($id);
        
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        };

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        };

        //REDIRECTED TO http://127.0.0.1:8001 -> User Frontend
        $frontend = config('app.frontend_url');
        return redirect()->to($frontend . '/email-verified');

    }
}
