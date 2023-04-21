<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRoomRequest extends FormRequest
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
            "id" => 'required',
            "room_number" => 'required',
            "cost_of_room" => 'required',
            "percentage_discount" => 'required',
            "state_of_occupancy" => "required",
            "date_of_availability" => "required"
        ];
    }

    public function messages()
    {
        return [
            "id.required" => 'The id is required',
            'room_number.required' => 'The room number is required.',
            'cost_of_room.required' => 'The cost of room is required.',
            'percentage_discount".required' => 'The percentage discouunt is required.',
            'state_of_occupancy.required' => 'The state of occupancy is required.',
            'date_of_availability.required' => 'The date of availablity is required.'

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
