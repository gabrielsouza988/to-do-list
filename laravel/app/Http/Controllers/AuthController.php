<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequests;
use App\Http\Requests\RegisterRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(LoginRequests $requests): JsonResponse
    {
        $input = $requests->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email ou senha invalidos!', 'hasError' => true], 200);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $requests): JsonResponse
    {
        try {
            $input = $requests->validated();

            User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($input['password']),
                'remember_token' => Str::random(10),
            ]);


            return response()->json(['message' => "Usuario(a) criada com sucesso!", 'hasError' => false], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 202);
    }

}
