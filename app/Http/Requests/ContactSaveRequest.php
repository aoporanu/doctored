<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSaveRequest extends FormRequest
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
            'firstname' => 'required', 'email' => 'required|email', 'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'First Name is required', 'email.required' => 'Emai Address is required ', 'description.required' => 'Message is required'
        ];
    }
}
