<?php

namespace App\Http\Requests;

use App\Rules\With;
use App\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        switch($method) {
            case 'GET':
                return [
                    'with' => new With([
                        'users', 'environments', 'endpoints', 'calls',
                    ]),
                    'paginate' => [
                        'min:1',
                        'integer',
                    ],
                ];

            case 'POST':
                $user = $this->user('api') ?? abort(401, 'Unauthenticated.');            

                return [
                    'name' => [
                        'required',
                        new Unique($user, 'projects'),
                    ],
                    'private' => [
                        'required',
                        'boolean',
                    ],
                ];

            case 'PUT':
            case 'PATCH':
                $user = $this->user('api') ?? abort(401, 'Unauthenticated.');

                return [
                    'name' => [
                        'required',
                        new Unique($user, 'projects', $this->project),
                    ],
                    'private' => [
                        'required',
                        'boolean',
                    ],
                ];

            default:
                return [
                    //
                ];
        }
    }
}
