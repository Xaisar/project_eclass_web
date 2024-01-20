<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{
    private $routeName;
    public function __construct()
    {
        $this->routeName = request()->route()->getName();
    }
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
            'identity_number' => [
                'required',
                $this->routeName == 'teacher.store' ? 'unique:teachers,identity_number' : Rule::unique('teachers', 'identity_number')->ignoreModel($this->teacher)
            ],
            'name' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'year_of_entry' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'picture' => 'mimes:png,jpg,jpeg',
            'last_education' => 'required',
        ];
    }
}
