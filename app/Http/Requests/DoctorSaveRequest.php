<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorSaveRequest extends FormRequest
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
            //  'phone' => 'unique:doctors',
            'phonenumber' => 'required|numeric|digits_between:10,12', //'phone:country|unique:patients'
            'phone' => 'unique:doctors',
            'email' => 'required|email|unique:doctors',

            'licence' => 'required|digits_between:7,7|unique:doctors',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'firstname.required' => 'First Name is required',
            'firstname.regex' =>
                'First Name format is invalid, use characters only',
            'lastname.required' => 'Last Name is required',
            'lastname.regex' =>
                'Last Name format is invalid, use characters only',
            'phonenumber.required' => 'Phone Number is required',
            'phone.unique' => 'Number already exists',
            'email.required' => 'Email Address is required ',
            'email.unique' =>
                'Record already existing with same Email address',
            'licence.required' => 'Licence/GMC is required',
            'licence.digits_between' => 'Licence should be 7 numbers',

            'password.required' => 'Password is required',
            'password.min' => 'Minimum 8 characters required',
            'password.regex' => 'Invalid Format',
            'password_confirmation.required' =>
                'Password Confirmation required',
            'password_confirmation.same' =>
                'Password Confirmation should be same Account password'
        ];
    }
}
