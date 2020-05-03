<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

/**
 * @Resource("Logout")
 */
class LogoutController extends Controller
{
    /**
     * Logout the user and invalidate the token.
     *
     *
     * @Post("/auth/logout")
     * @Request({})
     * @Response(200, body={"message": "Successfully logged out"})
     *
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()
            ->json(['message' => 'Successfully logged out']);
    }
}
