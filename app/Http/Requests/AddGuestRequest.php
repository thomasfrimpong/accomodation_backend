<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddGuestRequest extends FormRequest
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
            'other_names' => 'nullable',
            'phone_number' => 'required',
            'email' => 'nullable',
            'advert' => 'nullable',
            'added_by' => 'required'
        ];
    }

    public function messages()
    {
        return [

            'first_name.required' => 'The first name is required.',
            'phone_number.required' => 'The phone_number is required.',

            'added_by.required' => 'The person who added the record is required.'

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
