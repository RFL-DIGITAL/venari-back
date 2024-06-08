<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(request="SendMessageRequest", @OA\JsonContent(
 *     @OA\Property(property="toID",type="int"),
 *     @OA\Property(property="body",type="string"),
 *     @OA\Property(property="type",type="string"),
 *     @OA\Property(property="files", type="array",@OA\Items(type="string", format="binary",
 *     description="Массив файлов, без base64")),
 *     @OA\Property(property="images", type="array",
 *     @OA\Items(type="string", format="binary", description="Массив изображений, без base64")),
 * ))
 */
class SendMessageRequest extends FormRequest
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
