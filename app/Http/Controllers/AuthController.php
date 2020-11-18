<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    protected function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',

        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(Auth::user(),  200);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect',
        ]);

    }

    protected function logout()
    {
        Auth::logout();
        return response()->json([], 201);
    }

    protected function register(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        event(new Registered($user = $this->create($request->all())));

        Auth::guard()->login($user);

        return response()->json($user, 200);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
