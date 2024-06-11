<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\RequestBody(request="SendCommentRequest", @OA\JsonContent(
 *     @OA\Property(property="text",type="string"),
 *     @OA\Property(property="post_id",type="int"),
 *     @OA\Property(property="parent_id",type="int", description="id комментария, на который отвечаем. Необязательный
 * параметр"),
 * ))
 */
class SendCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
