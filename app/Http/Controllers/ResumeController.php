<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResumeRequest;
use App\Http\Requests\EditResumeRequest;
use App\Http\Requests\ResumeFileRequest;
use App\Services\ResumeService;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function __construct(protected ResumeService $resumeService) {}

    /**
     * Метод создания резюме из загруженного .doc файла
     *
     *
     *
     * @param ResumeFileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoFromDoc(ResumeFileRequest $request)
    {
        if (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) != "doc") {
            return $this->failureResponse(
                [
                    'message' => 'Неправильный формат документа. Попробуйте .doc'
                ]
            );
        }

        return $this->successResponse(
            $this->resumeService->createResumeFromFile($request)
        );

    }

    /**
     * Метод получения резюме по id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResumeByID($id) {
        return $this->successResponse(
            $this->resumeService->getResumeByID($id)
        );
    }

    /**
     * Метод создания резюме
     *
     * @OA\Schema(schema="createResume",
     *                   @OA\Property(property="success",type="boolean",example="true"),
     *                   @OA\Property(property="response",type="array",
     *                        @OA\Items(ref="#/components/schemas/resume")),
     *        )
     *
     * @OA\Post(
     *             path="/api/hr-panel/resumes/create-resume",
     *             tags={"HR-panel"},
     *             @OA\RequestBody(ref="#/components/requestBodies/CreateResumeRequest"),
     *             @OA\Response(
     *             response="200",
     *             description="Ответ при успешном выполнении запроса",
     *             @OA\JsonContent(ref="#/components/schemas/createResume")
     *           )
     *         )
     *
     * @param CreateResumeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createResume(CreateResumeRequest $request) {
        return $this->successResponse(
            $this->resumeService->createResume(
                $request->user_id,
                $request->contact_phone,
                $request->contact_mail,
                $request->salary,
                $request->description,
                $request->programSchools,
                $request->userPositions,
                $request->employment_id,
                $request->specialization_id,
                $request->position,
                $request->languageLevels,
                $request->skills,
                $request->format_id,
            )
        );
    }

    /**
     * Метод обновления данных в резюме
     *
     * @param EditResumeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editResume(EditResumeRequest $request) {
        return $this->successResponse(
            $this->resumeService->editResume(
                $request->id,
                $request->user_id,
                $request->contact_phone,
                $request->contact_mail,
                $request->salary,
                $request->description,
                $request->programSchools,
                $request->userPositions,
                $request->employment_id,
                $request->specialization_id,
                $request->position,
                $request->languageLevels,
                $request->skills,
                $request->format_id,
            )
        );
    }


}
