<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMemberRequest extends FormRequest
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
            'phone' => 'phone:GB|unique:patients,phone,' . $request->patient_id,
            'email' => 'required|email|unique:patients,email,' . $request->patient_id,
            'address_line1' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'address_city' => 'required',
            'address_country' => 'required',
            'address_postcode' => 'required',
            'emer_firstname' => ['nullable', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'emer_lastname' => ['nullable', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'emer_phone' => 'nullable|phone:GB',
            'emer_email' => 'nullable|email'
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
            'email.required' => 'Emai Address is required ',
            'email.unique' => 'Record already existing with same Email address',
            'address_line1.required' => 'Address Line 1 is required',
            'address_line1.regex' => 'Invalid Address Line 1(Allowed /.,-)',
            'address_city.required' => 'City is required',
            'address_country.required' => 'Country is required',
            'address_postcode.required' => 'Postal code is required',
            'address_postcode.postal_code_for' => 'postal code should match with country',
            'emer_firstname.regex' => 'Invalid Emergency First Name',
            'emer_lastname.regex' => 'Invalid Emergency Last Name',
            'emer_phone.phone' => 'Invalid Emergency Phone number(+441234567890)',
            'emer_email.email' => 'Invalid Emergency Email'
        ];
    }
}
