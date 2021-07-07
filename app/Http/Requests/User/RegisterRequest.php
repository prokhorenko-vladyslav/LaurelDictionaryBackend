<?php

namespace App\Http\Requests\User;

use App\DTO\UserRegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'min:8', 'max:255' ],
            'email' => [ 'required', 'string', 'email', 'max:255' ],
            'password' => [ 'required', 'string', 'alphadash', 'min:8', 'max:255' ]
        ];
    }

    public function getDTO(): UserRegisterDTO
    {
        return new UserRegisterDTO(
            $this->input('name'),
            $this->input('email'),
            $this->input('password')
        );
    }
}
