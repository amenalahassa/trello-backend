<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function show(Request $request)
    {
//        Todo : Send only need data, reduce withcount and other

        $user = Auth::user();
        return response()->json([
            'user' => collect($user)->except(['created_at', 'email_verified_at', 'updated_at']),
        ], 200);
    }

}
