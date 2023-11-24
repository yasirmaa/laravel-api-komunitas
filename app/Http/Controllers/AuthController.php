<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthController extends Controller
{
    use HttpResponses, SoftDeletes;

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->error(null, 'Email or password is incorrect!', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24);

        return $this->success(['token' => $token], 'User logged in successfully')->withCookie($cookie);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:255'
        ]);

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24);

        return $this->success([
            'user' => $user,
        ], 'User registered successfully')->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $cookie = cookie()->forget('token');

        return $this->success(null, 'Logged out successfully!')->withCookie($cookie);
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        $products = (new ProductController)->showByUser($user->username);
        return response()->json([
            'user' => $user,
            'products' => $products
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);

            $user->update($request->only([
                'firstname', 'lastname', 'username', 'email', 'no_phone', 'address'
            ]));

            return $this->success($user, "Product updated successfully", 200);
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }
}
