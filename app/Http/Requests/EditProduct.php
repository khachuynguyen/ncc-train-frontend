<?php

namespace App\Http\Requests;

use App\Rules\IsValidImageOrString;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class EditProduct extends AddProduct
{
    public function rules()
    {
        return [
            'product_name' => 'string|max:32',
            'product_id' => 'required',
            'manu_id' => 'exists:manufacturers,id',
            'cate_id' => 'exists:categories,id',
            'price' => 'digits_between:5,10',
            'image' => 'file|mimes:png,jpg,jpeg',
            'description' => 'string|max:500',
            '1' => [new IsValidImageOrString()],
            '2' => [new IsValidImageOrString()],
            '3' => [new IsValidImageOrString()],
            '4' => [new IsValidImageOrString()],
        ];
    }

}
