<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserContacts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:contacts|max:100',
			'nick_name' => 'nullable|max:50',
			'gender' => 'nullable|max:1',
			'email' => 'required|email|max:1|unique:contacts',
			'phone' => 'required|integer',
			'address' => 'required|alpha_num',
			'company' => 'required',
			'birth_date' => 'present|date|before_or_equal:today'
        ];
    }
}
