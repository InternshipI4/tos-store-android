<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class SignupRequest extends Request
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
            'first_name'=>'required|alpha|max:10',
            'last_name'=>'required|alpha|max:10',
            'store_name'=>'required|max:50',
            'phone_number'=>'required|min:9|max:10',
        ];
    }
}
