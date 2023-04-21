<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddPaymentRequest extends FormRequest
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
            'guest_id' => 'required',
            'amount' => 'required',
            'service_id' => 'required',
            'added_by' => 'required',
            "is_invalid" => 'nullable',
            'is_reserved' => 'nullable',
            'room_id' => 'required'

        ];
    }



    public function messages()
    {
        return [

            'guest_id.required' => 'The first name is required.',
            'amount.required' => 'The phone_number is required.',
            'service_id' => 'The service id is required',
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
