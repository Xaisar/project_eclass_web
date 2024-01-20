<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
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
            'name' => 'required',
            'start_entry' => 'required',
            'start_time_entry' => 'required',
            'last_time_entry' => 'required',
            'start_exit' => 'required',
            'start_time_exit' => 'required',
            'last_time_exit' => 'required',
        ];
    }
}
