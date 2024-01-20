<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'major_id' => $this->routeName == 'students.profile.update-profile' ? 'nullable' : 'required',
            'name' => 'required',
            'identity_number' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'parent_phone_number' => 'required',
            'picture' => 'mimes:png,jpg,jpeg',
            'address' => 'required',
            'birthplace' => 'required',
            'birthdate' => 'required',
        ];
    }
}
