<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422)
        );
    }

    public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'authorId' => 'required|integer|exists:authors,id',
        'publicationYear' => 'required|integer',
        'isbn' => 'nullable|string',
        'genre' => 'nullable|string',
        'availableCopies' => 'required|integer',
    ];
}

}
