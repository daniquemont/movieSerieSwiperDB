<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function register(Request $request){
        // $fields = $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string',
        //     'password' => 'required|string|confirmed'
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
        
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);

        // if($validator->fails()){
        //     return response()->json(['status_code'=> 400, 'message'=>'Bad Request']);
        // }

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = bcrypt($request->password);
        // $user->save();

        // return response()->json([
        //     'status_code'=>200, 'message'=>'User created successfully'
        // ]);

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

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

        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if($validator->fails()){
        //     return response()->json(['status_code'=> 400, 'message'=>'Bad Request']);
        // }

        // $credentials = $request(['email', 'password']);

        // if(!Auth::attempt($credentials)){
        //     return response()->json([
        //         'status_code' => 500, 'message' => 'Unauthorized'
        //     ]);
        // }

        // $user = User::where('email', $request->email)->first();

        // $tokenResult = $user->createToken('authToken')->plainTextToken;

        // return response()->json([
        //     'status_code' => 200, 'token' => $tokenResult
        // ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'message' => 'Verkeerde gebruikersnaam of wachtwoord'
            ], 401); 
        }
        
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 dag

        return response([
            'message' => "U bent ingelogd!" //$token
        ], 200)->withCookie($cookie);
    }

    public function user(){
        $user = Auth::user();
        if ($user != null) {
            return response([
                'user' => $user
            ]);

            if ($user == null) {
                return response([
                    'message' => 'U bent niet ingelogd!'
                ], 401); 
            }
        }
    }

    public function logout(Request $request){
        // $request->user()->currentAccessToken()->delete();
        
        // return response()->json([
        //     'status_code' => 200, 'message' => 'Token deleted successfully'
        // ]);

        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'OK'
        ], 200)->withCookie($cookie);
    }

}
