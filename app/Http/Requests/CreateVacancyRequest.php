<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(request="CreateVacancyRequest", @OA\JsonContent(
 *     @OA\Property(property="position_name"),
 *     @OA\Property(property="department_id", type="int"),
 *     @OA\Property(property="specialization_id", type="int"),
 *     @OA\Property(property="city_id", type="int"),
 *     @OA\Property(property="lower_salary", type="float"),
 *     @OA\Property(property="upper_salary", type="float"),
 *     @OA\Property(property="responsibilities"),
 *     @OA\Property(property="requirements"),
 *     @OA\Property(property="conditions"),
 *     @OA\Property(property="additional"),
 *     @OA\Property(property="additional_title"),
 *     @OA\Property(property="skills", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="experience_id", type="int"),
 *     @OA\Property(property="employment_id", type="int"),
 *     @OA\Property(property="format_id", type="int"),
 *     @OA\Property(property="test"),
 *     @OA\Property(property="status_id", type="int"),
 *     @OA\Property(property="image")
 * ))
 */
class CreateVacancyRequest extends FormRequest
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
            //
        ];
    }
}
