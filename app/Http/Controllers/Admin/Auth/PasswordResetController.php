<?php

namespace App\Http\Controllers\Admin\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\PasswordCreateRequest;
use App\Http\Requests\Admin\Auth\PasswordResetRequest;
use App\Jobs\Admin\Auth\PasswordResetJob;
use App\Jobs\Admin\Auth\PasswordResetSuccess;
use App\Models\User\User;
use App\Models\User\PasswordReset;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param   [string]    email
     * @return  [string]    message
     */
    public function create(PasswordCreateRequest $request) {
        $user = User::where('email', $request->email)->firstOrFail();

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );

        if($user && $passwordReset) {
            $this->dispatch(
                new PasswordResetJob($user, $passwordReset->token)
            );
        }

        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ], 201);
    }

    /**
     * Find token password reset
     *
     * @param   [string]    $token
     * @return  [string]    message
     * @return  [json]      passwordReset object
     */
    public function find($token) {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();

        if(Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 401);
        }

        return response()->json($passwordReset);
    }
    /**
     * Reset Password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(PasswordResetRequest $request) {
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->firstOrFail();

        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $this->dispatch(new PasswordResetSuccess($user));

        return response()->json([
            'message' => 'Reset password successful'
        ], 201);
    }
}
