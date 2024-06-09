<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\RequestBody(request="SendCommentRequest", @OA\JsonContent(
 *     @OA\Property(property="text",type="string"),
 *     @OA\Property(property="postID",type="int"),
 *     @OA\Property(property="parentID",type="int", description="id комментария, на который отвечаем. Необязательный
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
