<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
    * Display the user's profile.
    */
    public function show(User $user): View
    {
        $posts = $user->posts()->latest()->paginate(5);
        $comments = $user->comments()->latest()->paginate(5);

        return view('users.profile', [
            'user' => $user,
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }
}
