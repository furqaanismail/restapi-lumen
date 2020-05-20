<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        //
    }

    public function register(Request $request){
        $this->validate($request, [
           'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $hashPassword = Hash::make($password);

        $user = User::create([
           'email' => $email,
           'password' => $hashPassword
        ]);

        return response()->json(['message'=> 'succes'], 201);
    }

    public function login(Request $request){
        $this->validate($request, [
           'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json(['message'=> 'login failed'], 401);
        }

        $isvalidPassword = Hash::check($password, $user->password);
        if(!$isvalidPassword){
            return response()->json(['message'=> 'login failed'], 401);
        }


        $generatetoken = bin2hex(random_bytes(40));
        $user->update([
           'token' => $generatetoken
        ]);

        return response()->json($user);

    }

}
