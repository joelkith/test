<?php

namespace App\Api\V1\Controllers\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
// use Auth;

/**
 * @Resource("Login")
 */
class LoginController extends Controller
{
    /**
     * Login as a user.
     *
     * Middleware Guest
     *
     * @Post("/auth/login")
     * @Request({"email": "email", "password": "string"})
     * @Response(200, body={"status": "ok", "token": "token", "expires_in": "ttl in minutes"})
     *
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);
        // 60 * 24 * 30 * 6 i.e. 6 months
        // if($request->input('remember')) auth('api')->factory()->setTTL(259200);
        if($request->input('remember')) $JWTAuth->factory()->setTTL(259200);


        try {
            // $token = Auth::guard()->attempt($credentials);
            $token = $JWTAuth->attempt($credentials);

            if(!$token) {
                // throw new UnauthorizedHttpException('');
                // throw new AccessDeniedHttpException;
                abort(401, 'Incorrect Credentials');
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'expires_in' => $JWTAuth->factory()->getTTL() * 60,
                // 'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]);
    }
}
