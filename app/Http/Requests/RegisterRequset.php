<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(request="RegisterRequest", @OA\JsonContent(
 *     @OA\Property(property="email",type="string"),
 *     @OA\Property(property="password",type="string"),
 *     @OA\Property(property="login",type="string"),
 *
 * ))
 */
class RegisterRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'email|required',
            'login' => 'required|string|min:8',
            'password' => 'required|string|min:8',
        ];
    }
}
