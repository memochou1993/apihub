<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = Auth::guard('api')->user();

        if (! $user) {
            return response(null, 204);
        }

        $user->token()->revoke();

        return response(null, 200);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return Auth::guard('api')->user();
    }
}
