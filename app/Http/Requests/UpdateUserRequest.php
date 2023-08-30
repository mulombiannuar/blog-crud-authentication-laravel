<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    use PasswordValidationRules;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        //dd($this->user);
        //$user = User::find($this->user);
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_role' => ['nullable', 'integer'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user),
            ],
            'mobile_number' => [
                'required',
                'string',
                'max:255',
                'digits:10',
                'max:10',
                'min:10',
                Rule::unique('users')->ignore($this->user),
            ],
        ];
    }
}
