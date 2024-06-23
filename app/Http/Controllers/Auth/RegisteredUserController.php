<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'pgp_public_key' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pgp_public_key' => $request->pgp_public_key,
        ]);

        Auth::login($user);

        if ($request->filled('pgp_public_key')) {
            $originalMessage = $this->generateRandomString();
            session(['original_message' => $originalMessage]);

            return redirect()->route('verify-pgp.form');
        }

        return redirect()->route('dashboard');
    }

    private function encryptMessage($publicKey, $message)
    {
        $venvPath = base_path('storage/app/scripts/venv/bin/python3');
        $scriptPath = storage_path('app/scripts/pgp_encrypt.py');
        $process = new Process([$venvPath, $scriptPath, $publicKey, $message]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function generateRandomString($length = 16)
    {
        return bin2hex(random_bytes($length / 2));
    }

    public function verifyPgpForm(Request $request): View
    {
        $user = Auth::user();

        if (!$user || !$user->pgp_public_key) {
            abort(403, 'User does not have a PGP public key.');
        }

        $originalMessage = session('original_message');

        if (!$originalMessage) {
            abort(403, 'No original message found in session.');
        }

        $encryptedMessage = $this->encryptMessage($user->pgp_public_key, $originalMessage);

        return view('auth.verify-pgp', compact('encryptedMessage'));
    }

    public function verifyPgp(Request $request): RedirectResponse
    {
        $request->validate([
            'decrypted_message' => 'required|string',
        ]);

        $originalMessage = session('original_message');

        if ($request->decrypted_message === $originalMessage) {
            session()->forget('original_message');
            return redirect()->route('dashboard')->with('status', 'PGP verification successful.');
        }

        return redirect()->back()->withErrors(['decrypted_message' => 'Decryption failed. Please try again.']);
    }
}
