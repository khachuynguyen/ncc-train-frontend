<?php

namespace App\Rules;

use App\Supports\CheckValidateImage;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class IsValidImageOrString implements Rule
{

    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        if ($value instanceof UploadedFile) {
            return CheckValidateImage::checkImage($value);
        }
        if (is_string($value))
            return true;
        return false;
    }

    public function message()
    {
        return 'The validation error on slide.';
    }
}
