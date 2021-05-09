<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientSaveRequest extends FormRequest
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
            'firstname' => [
                'required',
                'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'
            ],
            'lastname' => [
                'required',
                'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'
            ],
            'phonenumber' => 'required|numeric|digits_between:9,12',
            'phonecode' => 'required',
            'phone' => 'unique:patients',
            'email' => 'required|email|unique:patients',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'First Name is required',
            'firstname.regex' =>
                'First Name format is invalid , use characters only',
            'lastname.regex' =>
                'Last Name format is invalid , use characters only',
            'phonenumber.required' => 'Phone Number  is required',
            'phone.unique' => 'Number is already exist ',
            'email.required' => 'Emai Address is required ',
            'email.unique' =>
                'Record already existing with same Email address',
            'password.required' => 'Password is required',
            'password.min' => 'Minimum 8 charcters required',
            'password.regex' => 'Invalid Format',
            'password_confirmation.required' =>
                'Password Confirmation required',
            'password_confirmation.same' =>
                'Password Confirmation  should be same Account password'
        ];
    }
}
