<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    // public function register(Request $request){
    //     $fields = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     $user = User::create([
    //         'name' => $fields['name'],
    //         'email' => $fields['email'],
    //         'password' => bcrypt($fields['password'])
    //     ]);

    //     $token = $user->createToken($request->name)->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($response, 201);
        
    // }

    // public function login(Request $request){
    //     $fields = $request->validate([
    //         'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     //check email
    //     $user = User::where('email', $fields['email'])->first();

    //     //check password
    //     if(!$user || !Hash::check($fields['password'], $user->password)){
    //         return response([
    //             'message' => 'Bad creds'
    //         ], 401);
    //     }

    //     $token = $user->createToken($request->name)->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     // return response($response, 201);
    //     return response()->json(User::all());
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return[
            'message' => 'Logged out'
        ];
    }
}
