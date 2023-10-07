<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //dd($this->user);
        //$user = User::find($this->user);
        return [
            'name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'integer'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('students')->ignore($this->user),
            ],
            'mobile_number' => [
                'required',
                'string',
                'max:255',
                'digits:10',
                'max:10',
                'min:10',
                Rule::unique('students')->ignore($this->user),
            ],
        ];
    }
}
