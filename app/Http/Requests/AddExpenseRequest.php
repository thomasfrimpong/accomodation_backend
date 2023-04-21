<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddExpenseRequest extends FormRequest
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
            'purpose_of_expense' => 'required',
            'amount_involved' => 'required',
            'added_by' => 'required'
        ];
    }


    public function messages()
    {
        return [

            'purpose_of_expense.required' => 'The purpose of expense is required.',
            'amount_involved.required' => 'The amount involved is required.',

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
