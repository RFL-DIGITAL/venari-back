<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(request="SendApproveRequest", @OA\JsonContent(
 *     @OA\Property(property="application_id", type="int"),
 *     @OA\Property(property="name"),
 *     @OA\Property(property="surname"),
 *     @OA\Property(property="is_approved", type="bool"),
 *     @OA\Property(property="comment"),
 * ))
 */
class SendApproveRequest extends FormRequest
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
            //
        ];
    }
}
