<?php

namespace Imrancse94\Grocery\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Imrancse94\Grocery\app\Exceptions\GroceryTokenExpiredException;
use Imrancse94\Grocery\app\Http\Requests\LoginRequest;
use Imrancse94\Grocery\app\Http\Requests\RefreshTokenRequest;
use Imrancse94\Grocery\app\Models\GroceryUser;
use Imrancse94\Grocery\app\Services\PermissionService;
use Imrancse94\Grocery\libs\JwtHelper;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (!$response = $this->guard()->attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }

        $response['permission'] = PermissionService::PERMISSIONS[$response['user']['role']] ?? [];

        return response()->json($response, 200);
    }

    public function getAuthenticatedUser(): JsonResponse
    {
        $auth_user = $this->guard()->user();

        if (!empty($auth_user)) {
            $response = $this->guard()->regenerateAuth(collect($auth_user));
            $response['permission'] = PermissionService::PERMISSIONS[$auth_user->role] ?? [];
            return response()->json($response,200);
        }
         return response()->json([
             'type'=>'unauthenticated',
             'message' => 'The user not found.'
            ],404);
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $token = $request->refresh_token;

        try {

            $user_id = JwtHelper::validateToken('refresh_token', $token);

            $user = GroceryUser::find($user_id);

            $response = $this->guard()->regenerateAuth($user);
            $response['permission'] = PermissionService::PERMISSIONS[$response['user']['role']] ?? [];

            return response()->json($response, 200);

        } catch (GroceryTokenExpiredException $ex) {
            return response()->json([
                'type' => 'token_expired',
                'error' => $ex->getMessage()
            ], 401);
        } catch (\Exception $ex) {
            return response()->json([
                'type' => 'unauthenticated',
                'error' => 'The refresh token is invalid'
            ], 401);
        }


    }

    private function guard($guard = 'grocery')
    {
        return Auth::guard($guard);
    }
}
