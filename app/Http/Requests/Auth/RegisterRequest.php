<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            //User_credentials confirm
            'username'=>['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required','confirmed', Password::defaults()],

            //Patient credentials confirm
            'first_name'=>['required', 'string', 'max:20'],
            'last_name'=>['required', 'string', 'max:20'],
            'age'=>['required', 'integer'],
            'sex'=>['required', 'integer'],
            'location'=>['required', 'string', 'max:255'],
        ];
    }
}
