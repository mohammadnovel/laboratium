<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $id = $this->route('permission');
        $unique = (!empty($id)) ? 'unique:permissions,id,' . $id : 'unique:permissions';
        return [
            'name' => 'sometimes|required|' . $unique . '|max:200|',
        ];
    }
}
