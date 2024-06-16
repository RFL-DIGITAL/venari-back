<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResumeRequest;
use App\Http\Requests\EditResumeRequest;
use App\Http\Requests\ResumeFileRequest;
use App\Services\ResumeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function __construct(protected ResumeService $resumeService) {}

    /**
     * Метод создания резюме из загруженного .doc файла
     *
     * @OA\Schema(schema="createResumeFromDoc",
     *                    @OA\Property(property="success",type="boolean",example="true"),
     *                    @OA\Property(property="response",type="array",
     *                         @OA\Items(ref="#/components/schemas/resume")),
     *         )
     *
     * @OA\Post(
     *              path="/api/resumes/create-from-file",
     *              tags={"Resume"},
     *              @OA\RequestBody(ref="#/components/requestBodies/ResumeFileRequest"),
     *              @OA\Response(
     *              response="200",
     *              description="Ответ при успешном выполнении запроса",
     *              @OA\JsonContent(ref="#/components/schemas/createResumeFromDoc")
     *            )
     *          )
     *
     * @param ResumeFileRequest $request
     * @return JsonResponse
     */
    public function createResumeFromDoc(ResumeFileRequest $request)
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
     * @OA\Schema(schema="getResumeByID",
     *                     @OA\Property(property="success",type="boolean",example="true"),
     *                     @OA\Property(property="response",type="array",
     *                          @OA\Items(ref="#/components/schemas/resume")),
     *          )
     *
     * @OA\Get(
     *               path="/api/resumes/{id}",
     *               tags={"Resume"},
     *     @OA\Parameter(
     *             name="id",
     *            in="query",
     *             description="id резюме",
     *             required=true),
     *               @OA\Response(
     *               response="200",
     *               description="Ответ при успешном выполнении запроса",
     *               @OA\JsonContent(ref="#/components/schemas/getResumeByID")
     *             )
     *           )
     *
     * @param $id
     * @return JsonResponse
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
     *             path="/api/resumes/create-resume",
     *             tags={"Resume"},
     *             @OA\RequestBody(ref="#/components/requestBodies/CreateResumeRequest"),
     *             @OA\Response(
     *             response="200",
     *             description="Ответ при успешном выполнении запроса",
     *             @OA\JsonContent(ref="#/components/schemas/createResume")
     *           )
     *         )
     *
     * @param CreateResumeRequest $request
     * @return JsonResponse
     */
    public function createResume(CreateResumeRequest $request) {
        return $this->successResponse(
            $this->resumeService->createResume(
                $request->user()->id,
                $request->contact_phone,
                $request->contact_mail,
                $request->salary,
                $request->description,
                $request->programSchools,
                $request->userPositions,
                $request->employment_id,
                $request->city_id,
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
     * @OA\Schema(schema="editResume",
     *                    @OA\Property(property="success",type="boolean",example="true"),
     *                    @OA\Property(property="response",type="array",
     *                         @OA\Items(ref="#/components/schemas/resume")),
     *         )
     *
     * @OA\Post(
     *              path="/api/resumes/edit-resume",
     *              tags={"Resume"},
     *              @OA\RequestBody(ref="#/components/requestBodies/EditResumeRequest"),
     *              @OA\Response(
     *              response="200",
     *              description="Ответ при успешном выполнении запроса",
     *              @OA\JsonContent(ref="#/components/schemas/editResume")
     *            )
     *          )
     *
     * @param EditResumeRequest $request
     * @return JsonResponse
     */
    public function editResume(EditResumeRequest $request) {
        return $this->successResponse(
            $this->resumeService->editResume(
                $request->id,
                $request->user()->id,
                $request->contact_phone,
                $request->contact_mail,
                $request->salary,
                $request->description,
                $request->programSchools,
                $request->userPositions,
                $request->employment_id,
                $request->city_id,
                $request->specialization_id,
                $request->position,
                $request->languageLevels,
                $request->skills,
                $request->format_id,
            )
        );
    }


}
