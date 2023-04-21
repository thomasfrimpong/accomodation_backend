<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            "id" => 'required',
            'first_name' => 'required',
            'other_names' => 'required',
            'phone_number' => 'required',
            "employee_id" => 'required',
            'role' => 'required',
            'email' => 'required'
        ];
    }


    public function messages()
    {
        return [
            "id" => 'The id is required',
            'first_name.required' => 'The first name is required.',
            'other_names.required' => 'The other names is required.',
            'phone_number.required' => 'The phone number is required.',
            'employee_id.required' => 'The employee is required',
            'role.required' => 'The role is required.',
            'email.required' => 'The email is required.'

        ];
    }

    protected function failedValidation(Validator $validator)
    {


        throw new HttpResponseException(response()->json(

            ['success' => false, 'message' =>  $validator->errors()->all()],
            422
        ));
    }
}
