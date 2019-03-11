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
    public function login()
    {
        $credentials = $this->request->only('email', 'password');

        if(! Auth::attempt($credentials)) {
            return response([
                'message' => 'The user credentials were incorrect.'
            ], 401);
        }

        $token_result = $this->request->user()->createToken('Personal Access Token');

        $token = $token_result->token;

        if ($this->request->remember_me) {
            $token->expires_at = now()->addDays(7);
            $token->save();
        }

        return response([
            'token_type' => 'Bearer',
            'expires_at' => $token->expires_at->toDateTimeString(),
            'access_token' => $token_result->accessToken,
        ]);
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
