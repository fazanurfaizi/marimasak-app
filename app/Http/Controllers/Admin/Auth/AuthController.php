<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use Avatar;
use Storage;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Http\Requests\Admin\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * Login user and create access token
     *
     * @param   [string]    email
     * @param   [string]    password
     * @param   [boolean]   remember_me
     * @return  [string]    access_token
     * @return  [string]    token_type
     * @return  [string]    expires_at
     */
    public function login(LoginRequest $request) {
        $credentials = request(['email', 'password']);
        // only active user, who can login
        $credentials['status'] = 'active';
        $credentials['deleted_at'] = null;

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unathorized'
            ], 401);
        }

        $user = $request->user();

        // Generate JWT
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if($request->remember_me) {
            $token->expires_at = Carbon::now()->addMonths(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ], 200);
    }

    /**
     * Get the aunthenticated User
     *
     * @return [json] User object
     */
    public function user(Request $request) {
        return response()->json($request->user());
    }

    /**
     * Logout User (Revoke the token)
     *
     * @return  [string]    message
     */
    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }
}
