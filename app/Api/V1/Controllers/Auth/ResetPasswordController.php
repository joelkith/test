<?php

namespace App\Api\V1\Controllers\Auth;

use Config;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\ResetPasswordRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @Resource("Reset Password")
 */
class ResetPasswordController extends Controller
{

    /**
     * Reset user's password after forgot password request.
     *
     * After resetting, it invalidates the token used to change the password and issues a new token.
     *
     * @Post("/auth/reset")
     * @Request({
     *      "password": "string",
     *      "password_confirmation": "matching password field",
     * })
     * @Response(200, body={"status": "ok", "token": "token", "expires_in": "ttl in minutes"})
     *
     */
    public function resetPassword(ResetPasswordRequest $request, JWTAuth $JWTAuth)
    {
        $user = auth()->user();
        $user->password = $request->input('password');
        if(!$user->email_verified_at) $user->email_verified_at = now();
        $user->save();     

        $JWTAuth->invalidate($request->input('token'));

        /*if(!Config::get('boilerplate.reset_password.release_token')) {
            return response()->json([
                'status' => 'ok',
            ]);
        }*/

        return response()->json([
            'status' => 'ok',
            'token' => $JWTAuth->fromUser($user),
            'expires_in' => $JWTAuth->factory()->getTTL() * 60,            
        ]);
    }
}
