<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'login' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        $creds = $request->only(['login', 'password']);

        if (Auth::attempt($creds)) {
            $user = Auth::user();
            $token = Str::random(60);

            if ($user !== null) {
                $user->api_token = $token;
                $user->save();

                return response()->json(['token' => $token], 200);
            }
        }

        return response()->json(['message' => 'Такого пользователя не существует'], 404);
    }

    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|max:255',
            'login' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User([
            'name' => $request->name,
            'login' => $request->login,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json(['message' => 'Регистрация прошла успешна']);

    }

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

    public function logout(Request $request)
    {
        {
            $user = $request->user();
            $user->api_token = null;
            $user->save();
            return response()->json(['message' => 'Вы успешно вышли'], 200);
        }
    }
}
