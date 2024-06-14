<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\ApplicationService;
class ApplicationController extends Controller
{

    public function __construct(protected ApplicationService $applicationService) {}



    public function getApplication(Request $request) {
        
        $applications = $this->applicationService->getApplications($request->get('department_id'), $request->get('vacancy_id'));

        return $this->successResponse($applications);
    }

    public function getApplicationByID(int $application_id) {
        $applications = $this->applicationService->getApplicationByID($application_id);

        return $this->successResponse($applications);
    }

    public function getUsers(Request $request) {
        $experience_id = $request->get('experience_id');
        $city_id = $request->get('city_id');
        $specialization_id = $request->get('specialization_id');
        $employment_id = $request->get('employment_id');
        $program_type_id = $request->get('program_type_id');
        $higher_salary = $request->get('higher_salary');
        $lower_salary = $request->get('lower_salary');

        $users = $this->applicationService->getUsers(
            $experience_id,
            $city_id,
            $specialization_id,
            $employment_id,
            $program_type_id,
            $higher_salary,
            $lower_salary
        );

        return $this->successResponse($users);

    }

}
