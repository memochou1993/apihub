<?php

namespace App\Http\Controllers\Api;

use App\User;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except([
            'login',
        ]);

        $default_user = User::find(config('defalut.user'));

        $this->user = $default_user ? Passport::actingAs($default_user) : Auth::guard('api')->user();
    }
}
