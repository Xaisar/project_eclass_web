<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'class_group_id' => 'required',
            'teacher_id' => 'required',
            'study_year_id' => 'required',
            'semester' => 'required',
            'meeting_numbers' => 'required|numeric',
            'thumbnail' => 'mimes:png,jpg,jpeg',
            'subject_id' => 'required',
            'status' => 'required|in:open,close',
        ];
    }
}
