<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // GET: show
    public function show(Request $request, User $user)
    {
        return view('users.show', compact('user'));
    }

    // GET: edit
    public function edit(Request $request, User $user)
    {
        return view('users.edit', compact('user'));
    }

    // PUT: update
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
