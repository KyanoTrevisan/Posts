<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class PgpVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'decrypted_message' => 'required|string',
        ]);

        $randomString = session('pgp_verification_random_string');
        if ($request->decrypted_message === $randomString) {
            // PGP verification successful, save the user and redirect to profile
            $user = User::find(Auth::id());
            $user->pgp_verified_at = now();
            $user->save();

            session()->forget(['pgp_verification_message', 'pgp_verification_random_string']);

            return Redirect::route('profile.edit')->with('status', 'pgp-verified');
        } else {
            return Redirect::back()->withErrors(['decrypted_message' => 'The decrypted message is incorrect.']);
        }
    }
}
