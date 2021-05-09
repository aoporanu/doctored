<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapDoctorRequest extends FormRequest
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
            'hospital' => ['required'],
            'doc_licence' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'hospital.required' => 'Please select hospital',
            'doc_licence.required' => 'Please select doctor'
        ];
    }
}
