<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
    public function create_account(request $request){
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'last_name' => 'required|min:4|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:password'
        ]);
         if ($validator->fails()) {
            return response()->json([
                'message' => 'validation fails',
                'errors' => $validator->errors()
            ], 422);
        }
      

$user=User::create([
    'name'=>$request->name,
    'last_name'=>$request->last_name,
    'email'=>$request->email,
    'password'=>Hash::make($request->password)
  ]);
  return response()->json([
    'message'=>'enregistrer avec succées',
    'data'=>$user,
],200); 
}
public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'message' => 'validation fails',
            'erreur' => $validator->errors(),
        ], 400);
    }
    
    // Attempt to authenticate the user with the provided credentials
    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        // Authentication successful, return the authenticated user data
        return response()->json([
            'message' => 'Authentication successful',
            'data' => auth()->user(),
        ], 200);
    } else {
        // Authentication failed, return an error response
        return response()->json([
            'message' => 'Authentication failed',
            'erreur' => 'Invalid credentials',
        ], 200);
    }
}
}