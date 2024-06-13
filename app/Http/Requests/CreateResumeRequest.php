<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 * @OA\RequestBody(request="CreateResumeRequest", @OA\JsonContent(
 *      @OA\Property(property="contact_phone", type="string"),
 *      @OA\Property(property="contact_mail", type="string"),
 *      @OA\Property(property="salary", type="string"),
 *      @OA\Property(property="description", type="string"),
 *      @OA\Property(property="programSchools", type="array", @OA\Items(ref="#/components/schemas/programSchoolsSchema")),
 *      @OA\Property(property="userPositions", type="array", @OA\Items(ref="#/components/schemas/userPositionsSchema")),
 *      @OA\Property(property="employment_id", type="int"),
 *      @OA\Property(property="specialization_id", type="int"),
 *      @OA\Property(property="format_id", type="int"),
 *      @OA\Property(property="position", type="string"),
 *      @OA\Property(property="languageLevels", type="array", @OA\Items(ref="#/components/schemas/languageLevelSchema")),
 *      @OA\Property(property="skills", type="array", @OA\Items(type="string")),
 *  ))
 */
class CreateResumeRequest extends FormRequest
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
