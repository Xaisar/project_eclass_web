<?php

namespace App\Http\Requests;

use App\Rules\AttachmentItemRule;
use Illuminate\Foundation\Http\FormRequest;

class TeachingMaterialRequest extends FormRequest
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
            'type' => 'required',
            'name' => 'required',
            'core_competence_id' => 'required',
            'basic_competence_id' => 'required',
            'attachment_item' => $this->hasFile('attachment_item') ? array_merge(['required'], $this->determineMediaValidationRule()) : 'required',
        ];
    }

    protected function determineMediaValidationRule()
    {
        switch ($this->type) {
            case 'image':
                return ['mimes:jpg,jpeg,png,bmp,gif', 'max:10000'];
            case 'video':
                return ['mimes:mp4,3gp,mkv,vlc'];
            case 'audio':
                return ['mimes:mp3,mp4,wav,avi'];
            default:
                return [];
        }
    }
}
