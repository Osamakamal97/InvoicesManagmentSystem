<?php

namespace App\Http\Requests;

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
        // dd($this->user->id);
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . (request()->method == 'PUT' ? $this->user->id : ''),
            'status' => 'required',
            'password' => 'required_with:is_create|confirmed',
            'password_confirmation' => 'required_with:is_create',
            'is_create' => 'nullable',
            'roles' => 'required|not_in:0'
        ];
    }
}
