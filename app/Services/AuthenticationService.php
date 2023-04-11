<?php 

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService 
{
    
    public function UserRegister(RegisterRequest $request)
    {
        $user = new User();
        $user->create($request->all());

        $return = $user->createToken('auth_token')->accessToken;
        
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->all();
        $user = User::where('email', $loginData['email'])->first();

        if(!$user || !(Hash::check($loginData['password'], $user->password))){
            return response()->json([
              'message' => 'Email or password is incorrect!'
            ], 401);
        }

        return $user->createToken('auth_token')->accessToken;
    }

}