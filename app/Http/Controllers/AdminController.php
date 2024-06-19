<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user with their posts
        $user = User::with('posts')->findOrFail(auth()->id());

        return view('admin.dashboard', compact('user'));
    }
}
