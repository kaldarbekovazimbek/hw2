<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>['required', 'string', 'max:40'],
            'birthday'=>['required','date','date_format:Y-m-d'],
            'email'=>['required', 'string', 'max:50'],
            'password'=> ['required', 'string', 'min:6', 'max:50'],
        ];
    }
}
