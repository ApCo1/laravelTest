<?php

namespace App\Http\Controllers\api\v1;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function register(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $validatedData['metaphone'] = metaphone($validatedData['name']);
        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);

    }

    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if(!auth()->attempt($login)){
            return response(['message' => 'Invalid login credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
