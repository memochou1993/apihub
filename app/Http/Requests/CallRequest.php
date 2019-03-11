<?php

namespace App\Http\Requests;

use App\Rules\With;
use Illuminate\Foundation\Http\FormRequest;

class CallRequest extends FormRequest
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
                        'endpoint',
                    ]),
                    'paginate' => [
                        'min:1',
                        'integer',
                    ],
                ];

            case 'POST':
                return [
                    'request' => [
                        'required',
                   ],
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'request' => [
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
