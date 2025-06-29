<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MemberUpdateRequest extends FormRequest
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
        $id = $this->route('id'); // Get the member ID from route

        return [
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:members,email,' . $id,
            'membership_date' => 'sometimes|required|date',
        ];
    }
}
