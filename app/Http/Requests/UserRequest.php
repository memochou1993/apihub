<?php

namespace App\Http\Requests;

use App\Rules\With;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                        'projects',
                    ]),
                    'paginate' => [
                        'min:1',
                        'integer',
                    ],
                ];

            case 'POST':
                return [
                    'username' => [
                        'required',
                        Rule::unique('users'),
                    ],
                    'name' => [
                        'required',
                    ],
                    'email' => [
                        'required',
                        Rule::unique('users'),
                    ],
                    'password' => [
                        'required',
                    ],
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'username' => [
                        'required',
                        Rule::unique('users')->ignore($this->user),
                    ],
                    'name' => [
                        'required',
                    ],
                    'email' => [
                        'required',
                        Rule::unique('users')->ignore($this->user),
                    ],
                    'password' => [
                        'required',
                    ],
                ];

            default:
                return [
                    //
                ];
        }
    }
}
