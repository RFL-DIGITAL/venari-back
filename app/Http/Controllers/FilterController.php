<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employment;
use App\Models\Experience;
use App\Models\Format;
use App\Models\HR;
use App\Models\Language;
use App\Models\Level;
use App\Models\Position;
use App\Models\Program;
use App\Models\ProgramType;
use App\Models\RejectReason;
use App\Models\School;
use App\Models\Specialization;
use App\Models\Status;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Stage;

class FilterController extends Controller
{
    public int $REKSOFT_COMPANY_ID = 1;

    /**
     * Метод получения всех доступных фильтров
     *
     * @OA\Schema( schema="getAllFilters",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
     *                   @OA\Items(ref="#/components/schemas/filter")),
     *   )
     *
     * @OA\Get(
     *        path="/api/hr-panel/filters",
     *        tags={"HR-panel"},
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getAllFilters")
     *      )
     *    )
     *
     * @return JsonResponse
     */
    public function getAllFilters(): JsonResponse
    {
        return $this->successResponse([
            'statuses' => Status::all()->toArray(),
            'employments' => Employment::all()->toArray(),
            'experiences' => Experience::all()->toArray(),
            'formats' => Format::all()->toArray(),
            'specializations' => Specialization::all()->toArray(),
            'departments' => Department::where('company_id', $this->REKSOFT_COMPANY_ID)->get()
                ->load('company.image')->toArray(),
            'accountables' => HR::where('company_id', $this->REKSOFT_COMPANY_ID)->get()
                ->load([
                    'user.image',
                    'user.preview',
                    'user.company.image',
                ])->toArray(),
            'program_types' => ProgramType::all()->toArray(),
            'stages' => Stage::all()->load('stageType')->toArray(),
            'templates' => Template::all()->toArray(),
            'reject_reasons' => RejectReason::all()->toArray(),
            'categories' => Category::all()->toArray()
        ]);
    }

    public function getFiltersForResumeCreation(): JsonResponse
    {
        return $this->successResponse([
            'employments' => Employment::all()->toArray(),
            'formats' => Format::all()->toArray(),
            'specializations' => Specialization::all()->toArray(),
            'city' => City::all()->toArray(),
            'languages' => Language::all()->toArray(),
            'level' => Level::all()->toArray(),
            'universities' => School::all()->toArray(),
            'programs' => Program::all()->toArray(),
            'program_types' => ProgramType::all()->toArray(),
            'companies' => Company::all()->toArray(),
            'positions' => Position::all()->toArray(),
        ]);
    }
}
