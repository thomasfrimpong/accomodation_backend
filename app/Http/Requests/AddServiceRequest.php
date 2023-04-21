<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddServiceRequest extends FormRequest
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
            'room_id' => 'required',
            "start_of_residence" => 'required|date_format:d-m-Y H:i:s',
            "end_of_residence" => 'required|date_format:d-m-Y H:i:s|after_or_equal:start_of_residence',
            "duration_extended" => 'nullable',
            "duration_reduced" => 'nullable',
            'added_by' => 'required',
            'guest_id' => 'required',
            'is_reservation' => 'nullable'
        ];
    }

    public function messages()
    {
        return [

            'room_id.required' => 'The room id is required.',
            'start_of_residence.required' => 'The start of residence is required(format d/m/Y H:i:s).',
            'end_of_residence.required' => 'The end of residence is required(format d/m/Y H:i:s).',

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
