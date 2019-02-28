<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Support\Facades\App;
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
        if (! App::environment('local')) {
            $this->middleware('auth:api');
            $this->user = Auth::user();
        } else {
            $this->user = User::find(config('seeds.user:first:id'));
        }
    }
}
