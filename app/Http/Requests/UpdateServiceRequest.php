<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateServiceRequest extends FormRequest
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
            "start_of_residence" => 'required',
            "end_of_residence" => 'required',
            "duration_extended" => 'required',
            "duration_reduced" => 'required'
        ];
    }

    public function messages()
    {
        return [
            "id.required" => 'The id is required',
            'start_of_residence.required' => 'The start of residence is required.',
            'end_of_residence.required' => 'The end of residence is required.',
            'duration_extended".required' => 'The duration extended is required.',
            'duration_reduced.required' => 'The duration reduced is required.',


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
