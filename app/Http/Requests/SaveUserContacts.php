<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Contact;

class SaveUserContacts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return true;
		return User::where('id', Auth::id())->exists();
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
            'email' => 'required|email|unique:contacts', 
            'phone' => 'required|numeric|phone_number',
            'address' => 'required|alpha_num_space',
            'company' => 'required',
            'birth_date' => 'present|date|before_or_equal:today'
        ];
    }
	
	/**
     * Add Custom Validation messages
     *
     * @return array
     */
	public function messages()
	{
		return [
			'phone_number' => 'The :attribute field must start with 01.',
			'alpha_num_space' => 'The :attribute field can consist of only letters, numbers and spaces.', 
		];
	}
}
