<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return [
                'data' => [
                    'user_token' => User::where(['login' => $request->login])->first()->generateToken()
                ]
            ];

        } else {
            return response()->json([
                'success' => false,
                'message' =>    'Invalid login details'
            ], 401);

        }
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {

        $user = new User([
            'name' => $request->name,
            'login' => $request->login,
            'password' => bcrypt($request->password)
        ]);


        $user->save();

        return response()->json([
            'success' => true,
        ]);

    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::paginate(15);

        UserResource::collection($user);

        return response()->json([
            'data' => $user ->all(),
            'currentPage' => $user -> currentPage(),
            'lastPage' => $user -> lastPage(),
        ]);
    }

    /**
     * Logout user (Revoke the token)
     */
    public function logout(Request $request)
    {
        $user = $request->user()->token();
        $user->revoke();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }
}
