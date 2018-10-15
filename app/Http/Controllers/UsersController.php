<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show($username) {
        $user = User::where('username', $username)->first();
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
