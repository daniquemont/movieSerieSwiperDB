<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        // $token = $user->createToken($request->name)->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        // return response($response, 201);
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken;
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            // 'email' => 'required|string|unique:users,email',
            // 'password' => 'required|string|confirmed'
            'email' => 'required|string|email|',
            'password' => 'required|string'
        ]);

        //check email
        // $user = User::where('email', $fields['email'])->first();

        // //check password
        // if(!$user || !Hash::check($fields['password'], $user->password)){
        //     return response([
        //         'message' => 'Bad creds'
        //     ], 401);
        // }

        // $token = $user->createToken($request->name)->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        // // return response($response, 201);
        // return response()->json(User::all());
        if (!Auth::attempt($fields)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return[
            'message' => 'Logged out'
        ];
    }
}
