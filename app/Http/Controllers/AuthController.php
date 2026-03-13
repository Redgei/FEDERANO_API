<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller {

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string|in:admin,staff',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role' => $request->role ?? 'staff'
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'=>$user,
            'token'=>$token
        ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json([
                'message'=>'Invalid Credentials'
            ],401);
        }

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'=>$user,
            'token'=>$token
        ]);
    }

}
