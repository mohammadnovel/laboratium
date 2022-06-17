<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SessionRequest extends FormRequest
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
        $id = $this->route('session');
        $unique_name = (!empty($id)) ? 'unique:sessions,phone,' . $id : 'unique:sessions,name';
        $unique_phone = (!empty($id)) ? 'unique:sessions,phone,' . $id : 'unique:sessions,phone';

        $return = [
            'name' => 'required|required|' . $unique_name,
            'phone' => 'required|numeric|' . $unique_phone,
        ];
        if (Auth::user()->type == 'super-admin') $return['company_id'] = 'required';

        return $return;
    }
}
