<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use App\Http\Resources\UserResource as Resource;

class AuthController extends ApiController
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
        parent::__construct();

        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        try {
            $client = new Client([
                'base_uri' => config('app.url'),
            ]);

            $response = $client->post('/api/users', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $this->request->all(),
            ]);

            return $response->getBody();
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        try {
            $client = new Client([
                'base_uri' => config('app.url'),
            ]);

            $response = $client->post('/oauth/token', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $this->request->all(),
            ]);

            return $response->getBody();
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->user->token()->revoke();

        return response(null, 204);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $user = $this->user;

        return new Resource($user);
    }
}
