<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookUpdateRequest extends FormRequest
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
        $id = $this->route('id'); // Get book ID from route

        return [
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|integer',
            'publication_year' => 'sometimes|required|integer',
            'isbn' => 'sometimes|required|string|max:20|unique:books,isbn,' . $id,
            'genre' => 'sometimes|required|string|max:100',
            'available_copies' => 'sometimes|required|integer|min:0',
        ];
    }
}
