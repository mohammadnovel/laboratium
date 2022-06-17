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
        $id = $this->route('user');
        $unique_email = (!empty($id)) ? 'unique:users,email,' . $id : 'unique:users,email';
        $unique_phone = (!empty($id)) ? 'unique:users,phone,' . $id : 'unique:users,phone';

        return [
            'name' => 'required',
            'email' => 'required|email|' . $unique_email,
            'phone' => 'numeric|' . $unique_phone,
            'type' => 'required',
            'password' => 'required',
        ];
    }
}
