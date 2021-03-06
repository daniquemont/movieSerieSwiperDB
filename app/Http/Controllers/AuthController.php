<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request){
        // $fields = $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
            
        // ]);

        // $user = User::create([
        //     'name' => $fields['name'],
        //     'email' => $fields['email'],
        //     'password' => bcrypt($fields['password'])
        // ]);

        // $token = $user->createToken($request->name)->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        // return response($response, 201);
        
        $validator = Validator::make($request-all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status_code' => 200,
            'message' => 'User created successfully'
        ])
    }

    public function login(Request $request){
        // $fields = $request->validate([
        //     'email' => 'required|string|unique:users,email',
        //     'password' => 'required|string|confirmed'
        // ]);

        // //check email
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
        
        $validator = Validator::make($request-all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }

        $credentials = requst(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'status_code' => 500,
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status_code' => 200,
            'message' => $tokenResult
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'status_code' => 200, 
            'message' => 'Token deleted successfully'
        ]);

    }

}
