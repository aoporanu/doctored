<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorAddRequest extends FormRequest
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
            'firstname' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'lastname' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'dob' => 'required|date|before:today',
            'timezone' => 'required',
            'phonecode' => 'required',
            'phone' => 'required|unique:doctors,phone',
            'email' => 'required|email|unique:doctors,email',
            'licence' => 'required|digits_between:7,7|unique:doctors,licence',
            'address_line1' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'address_city' => 'required',
            'address_state' => 'required',
            'address_country' => 'required',
            'address_postcode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'First Name is required',
            'firstname.regex' => 'First Name format is invalid , use characters only',
            'lastname.regex' => 'Last Name format is invalid , use characters only',
            'dob.required' => 'Date of Birth is required',
            'dob.date' => '  Date of Birth is invalid,Use Date format',
            'dob.before' => 'The Date of Birth must be a date before today. ',
            'phone.required' => 'Phone Number  is required',
            'phone.unique' => 'Record already existing with same phone number',
            'email.required' => 'Email Address is required ',
            'email.unique' => 'Record already existing with same Email address',
            'licence.required' => 'Licence/GMC is required',
            'licence.digits_between' => 'Licence should be 7 numbers',
            'address_line1.required' => 'Address Line 1 is required',
            'address_line1.regex' => 'Invalid Address Line 1(Allowed /.,-)',
            'address_city.required' => 'City is required',
            'address_country.required' => 'Country is required',
            'address_postcode.required' => 'Postal code is required',
            'address_postcode.postal_code_for' => 'postal code should match with country',
        ];
    }
}
