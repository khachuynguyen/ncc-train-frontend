<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class AddProduct extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => 'required|string|max:32',
            'manu_id' => 'required|exists:manufacturers,id',
            'cate_id' => 'required|exists:categories,id',
            'price' => 'required|digits_between:5,10',
            'image' => 'required|file|mimes:png,jpg,jpeg',
            'description' => 'nullable|string|max:500',
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
