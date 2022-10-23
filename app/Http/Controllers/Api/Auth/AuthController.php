<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => ['required','email'],
            'password' => ['required', 'string']
        ]);
        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $token = $user->createToken('sanctum')->plainTextToken;
            return response()->json([
                'message' => 'Success Login',
                'token' => $token,
                'success' => true
            ], 200);
        }
        return response()->json([
            'message' => 'Success Login',
            'success' => false
        ], 422);
    }

    public function checkAuth(){
        $auth = Auth::user();
        return response()->json([
            'message' => 'Success',
            'auth' => $auth
        ], 200);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Success',
            'logout' => true
        ], 401);
    }
}
