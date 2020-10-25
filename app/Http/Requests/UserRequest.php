<?php

namespace App\Http\Requests;

use App\User;
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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 'min:5' , 'not_regex:/([%\$#\*<>]+)/'
            ],
            'email' => [
                'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null) , 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'
            ],
            'password' => [
                $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'
            ],
            'admin' => [
                'required','integer','in:0,1'
            ]
        ];
    }
}
