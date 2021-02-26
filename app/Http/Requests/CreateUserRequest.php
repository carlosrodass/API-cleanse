<?php

namespace App\Http\Requests;
// App\Http\Requests\Validator;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
    
        $rules = [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($this->getMethod() == 'PUT') {
            $rules += [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ];
        }
        return $rules;
    
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {   
        $message = [
            'username.required' => 'Nombre de usuario es requerido',
            'email.required' => 'Email es requerido',
            'password.required' => 'Contraseña requerida',
        ];

        if ($this->getMethod() == 'PUT') {
            $message += [
                'username.required' => 'Nombre de usuario es requerido',
                'email.required' => 'Email es requerido',
                'password.required' => 'Contraseña requerida',
            ];
        }
        return $message;
    }

     /**
     * Instead of redirect to last view, show a json with errors.
     *@param Validator $validator
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['error' => $validator->errors()], 422));
    }


}
