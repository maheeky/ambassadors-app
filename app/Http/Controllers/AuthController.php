<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + [
                'password' => \Hash::make($request->input('password')),
                'is_admin' => 1
            ]
        );

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(\Auth::attempt($credentials)) {
            $user = \Auth::user();
            $jwt = $user->createToken('token', ['admin'])->plainTextToken;

            $cookie = cookie('jwt', $jwt, 60*24);//1 day

            return response([
                'message' => 'Successfully Authenticated'
            ])->withCookie($cookie); 
        } else {
            return response([
                'error' => 'Invalid credentials.'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return response([
            'message' => 'Successfully logged out'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
