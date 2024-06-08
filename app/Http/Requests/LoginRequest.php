<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;


/**
 * @OA\RequestBody(request="LoginRequest", @OA\JsonContent(
 *     @OA\Property(property="email",type="string"),
 *     @OA\Property(property="password",type="string"),
 *
 * ))
 */
class LoginRequest extends FormRequest
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
        $emails = User::all()->pluck('email');
        return [
            'email' => ['email', Rule::in($emails), 'required'],
            'password' =>  'required|string',
        ];
    }
}
