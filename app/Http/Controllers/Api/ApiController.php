<?php

namespace App\Http\Controllers\Api;

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

        $this->user = Auth::guard('api')->user();
    }
}
