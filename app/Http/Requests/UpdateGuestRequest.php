<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateGuestRequest extends FormRequest
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
            'id' => 'required',
            'first_name' => 'required',
            'other_names' => 'required',
            'advert' => 'required',
            'phone_number' => 'required',
            'email' => 'required'

        ];
    }


    public function messages()
    {
        return [
            "id.required" => 'The id is required',
            'first_name.required' => 'The first name is required.',
            'other_names.required' => 'The other names is required.',
            'phone_number.required' => 'The phone number is required.',
            'advert.required' => 'The advert is required.',
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
