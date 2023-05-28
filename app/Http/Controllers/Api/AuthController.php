<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>"required|min:3|max:20",
            'email'=>"required|email|unique:users,email",
            'password'=>"required|min:8|max:20"
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $token=$user->createToken('Blog')->accessToken;
        return ResponseHelper::success(['access-token'=>$token]);
        
    }
    
    public function login(Request $request){
        $formData=$request->validate([
            'email'=>"required",
            'password'=>"required"
        ]);
        
        if(auth()->attempt($formData))
        {
            $user=auth()->user();
            $token=$user->createToken('Blog')->accessToken;
            return ResponseHelper::success(['access-token'=>$token]);
        }
        else{
            return ResponseHelper::fail('Login Credentials are invalid');
        }
    }

    public function logout(Request $request){
        auth()->user()->token()->revoke();
        return ResponseHelper::success([],'Successfully logout');
    }
}
