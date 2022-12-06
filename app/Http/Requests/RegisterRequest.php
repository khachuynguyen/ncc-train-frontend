<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'r_password' => 'required|same:password'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            ['data' => null,
                'error' => $errors,
                'status_code' => 422,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

}
