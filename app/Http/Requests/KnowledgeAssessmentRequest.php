<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KnowledgeAssessmentRequest extends FormRequest
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
            'number_of_meeting' => 'required',
            'scheme' => 'required',
            'name' => 'required',
            'day_assessment' => 'required',
            // 'basic_competence' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }
}
