<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(request="SendMessageRequest", @OA\JsonContent(
 *     @OA\Property(property="to_id",type="int"),
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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'required|string',
            'image' => 'string',
            'file' => 'string'
        ];
    }
}
