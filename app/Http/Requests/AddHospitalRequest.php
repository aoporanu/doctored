<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddHospitalRequest extends FormRequest
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
            'phone' => 'required|numeric|digits_between:10,12|unique:hospitals,phone,' . $hospitalId . ',hospital_id',
            'licence' => 'required|digits_between:7,7|unique:hospitals,licence,' . $hospitalId . ',hospital_id',
            'email' => 'required|email|unique:hospitals,email,' . $hospitalId . ',hospital_id',
            'address_line1' => 'required',
            'address_line2' => 'required',
            'address_city' => 'required',
            'address_state' => 'required',
            'address_country' => 'required',
            'address_postcode' => 'required',
        ];
    }
}
