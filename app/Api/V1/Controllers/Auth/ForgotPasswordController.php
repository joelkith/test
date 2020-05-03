<?php

namespace App\Api\V1\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\ForgotPasswordRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Notifications\PasswordReset;
use App\Notifications\VerifyEmailAddress;


/**
 * @Resource("Forgot Password")
 */
class ForgotPasswordController extends Controller
{
    /**
     * User forgot password.
     *
     * @Post("/auth/recovery")
     * @Request({"email": "email"})
     * @Response(200, body={"status": "password sent"})
     *
     */
    public function sendResetEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->get('email'))->firstOrFail();

        $user->notify(new PasswordReset);

        return ['status' => trans('passwords.sent')];
    }

    public function resendVerifyEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->get('email'))->firstOrFail();

        $user->notify(new VerifyEmailAddress);

        return ['status' => trans('passwords.sent')];
    }

    public function verifyEmail()
    {
        $user = auth()->user();
        if($user){
            $user->email_verified_at = now();
            $user->save();
            return ['status' => 'Your email has bee verified. You can now login.'];
        }
        else{
            abort(403);
        }
    }
}
