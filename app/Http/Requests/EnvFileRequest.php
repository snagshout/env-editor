<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnvFileRequest extends FormRequest
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
            'path' => 'required|string',
            'lines' => 'array',
            'remove_key' => 'array',
            'lines.*.key' => Rule::requiredIf(function(){
                $lines = $this->get('lines', []);
                return count($lines) > 0;
            }),
        ];
    }
}
