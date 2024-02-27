<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'email'=>['required', 'string', 'max:50'],
            'password'=>['required', 'string', 'min:6', 'max:50'],
        ];
    }
}
