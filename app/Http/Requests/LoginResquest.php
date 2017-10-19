<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class LoginResquest extends Request
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
        return [
            'phone_number'=>'required|min:9|max:10',
        ];
    }
}
