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
        $this->user = config('default.auth') ? Auth::guard('api')->user() : Passport::actingAs(User::find(config('default.admin.id')));
    }
}
