<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'first_name' => 'required',
            'employee_id' => 'nullable',
            'other_name' => 'nullable',
            'phone_number' => 'required',
            'email' => 'required|unique:users,email',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email address has been used.',
            'first_name.required' => 'The first name is required.',
            'phone_number.required' => 'The phone_number is required.',

            'role.required' => 'The role of the user is required'

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
