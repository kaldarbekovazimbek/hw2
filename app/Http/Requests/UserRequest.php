<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:40'],
            'birthday'=>['required','date','date_format:Y-m-d'],
            'phone'=>['nullable', 'string', 'max:20'],
            'email'=>['required', 'string', 'max:50'],
            'password'=>['required', 'string', 'min:6', 'max:50'],
        ];
    }
}
