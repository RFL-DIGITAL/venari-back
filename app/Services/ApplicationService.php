<?php

namespace App\Services;

use App\Models\Application;
use App\Models\ApplicationGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Approve;

class ApplicationService
{


    private const REKSOFT_COMPANY_ID = 1;

    public function getApplications(?int $stage_id, ?int $vacancy_id)
    {
        $applicationsBuilder = Application::whereRelation('vacancy.department', 'company_id',
            $this::REKSOFT_COMPANY_ID);

        if ($stage_id != null) {
            $applicationsBuilder->where('stage_id', $stage_id);
        }

        if ($vacancy_id != null) {
            $applicationsBuilder->whereRelation('vacancy', 'id', $vacancy_id);
        }

        $applications = $applicationsBuilder->get();

        return $applications->load([
            'resume.user.position',
            'resume.user.image',
            'resume.user.company',
        ])->toArray();
    }

    public function getApplicationByID(int $application_id)
    {
        $applications = Application::where('id', $application_id)->with([
            "resume.user.city.country",
            "resume.userPositions.company",
            "resume.userPositions.position",
            "resume.languageLevels.language",
            "resume.languageLevels.level",
            "resume.skills",
            "resume.resumeProgramSchools.programSchool.program.programType",
            "resume.resumeProgramSchools.programSchool.school",
            "resume.position",
            "resume.specialization",
            "comments.user.image",
            "resume.user.tags",
            "approves"
        ]);

        return $applications->get()->toArray();
    }


    public function getUsers(
        ?int $experience_id,
        ?int $city_id,
        ?int $specialization_id,
        ?int $employment_id,
        ?int $program_type_id,
        ?int $higher_salary,
        ?int $lower_salary
    )
    {

        $usersBuilder = User::with('resumes');
        if ($experience_id) {
            $usersBuilder->whereRelation('resumes', 'experience_id', '=', $experience_id);
        }

        if ($city_id != null) {
            $usersBuilder->whereRelation('city', 'id', $city_id);
        }

        if ($specialization_id != null) {
            $usersBuilder->whereRelation('resume', 'specialization_id', $specialization_id);
        }

        if ($employment_id != null) {
            $usersBuilder->whereRelation('resume', 'employment_id', $employment_id);
        }

        if ($program_type_id != null) {
            $usersBuilder
                ->whereRelation('resume.resumeProgramSchools.programSchool', 'program_type_id', $program_type_id);
        }

        if ($higher_salary != null) {
            $usersBuilder
                ->whereRelation('resume', (int)'salary', '<', $higher_salary);
        }

        if ($lower_salary != null) {
            $usersBuilder
                ->whereRelation('resume', (int)'salary', '<', $lower_salary);
        }

        $users = $usersBuilder->get()
            ->load([
                'city.country',
                'company',
                'position',
                'image',
                'resumes.userPositions.company',
                'resumes.userPositions.position',
                'resumes.languageLevels.language',
                'resumes.languageLevels.level',
                'resumes.skills',
                'resumes.resumeProgramSchools.programSchool.program.programType',
                'resumes.resumeProgramSchools.programSchool.school',
                'resumes.position',
                'resumes.specialization',
                'tags'
            ]);

        return $users->toArray();

    }

    public function shareApplications(array $application_ids)
    {
        $applicationGroup = new ApplicationGroup();
        $applicationGroup->code = uniqid();
        $applicationGroup->save();

        foreach ($application_ids as $id) {
            $application = Application::where('id', $id)->first();
            $applicationGroup->applications()->save($application);
        }
        $applicationGroup->save();

        return route("getApplicationsByGroupCode", $applicationGroup->code);
    }

    public function getApplicationsByGroupCode($code)
    {
        $applicationGroup = ApplicationGroup::where('code', $code)->first();

        $applications = Application::whereHas('applicationGroups', function (Builder $query) use ($applicationGroup) {
            $query->where('application_groups.id', $applicationGroup->id);
        })->get();


        $users = [];

        foreach ($applications as $application) {
            $user = $application->resume->user;
            $user->load([
                'city.country',
                'company',
                'position',
                'image',
                'resumes.userPositions.company',
                'resumes.userPositions.position',
                'resumes.languageLevels.language',
                'resumes.languageLevels.level',
                'resumes.skills',
                'resumes.resumeProgramSchools.programSchool.program.programType',
                'resumes.resumeProgramSchools.programSchool.school',
                'resumes.position',
                'resumes.specialization',
                'tags'
            ]);

            $user = $user->toArray();
            $user['application_id'] = $application->id;

            $users[] = $user;
        }

        return $users;
    }

    public function sendApprove(int    $applicationID,
                                string $name,
                                string $surname,
                                bool   $isApproved,
                                string $comment)
    {
        $approve = new Approve([
            'name' => $name,
            'surname' => $surname,
            'status' => $isApproved,
            'application_id' => $applicationID,
            'text' => $comment
        ]);
        $approve->save();

        return $approve->toArray();
    }
}
