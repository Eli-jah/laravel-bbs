<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // GET: show
    public function show(Request $request, User $user)
    {
        return view('users.show', compact('user'));
    }
}
