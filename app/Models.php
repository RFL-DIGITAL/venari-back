<?php

namespace Responses {

    use App\DTO\MessageType;
    use OpenApi\Annotations as OA;

    class BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $name;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }


    /** @OA\Schema(schema="vacancy") */
    class Vacancy extends BaseClass
    {
        /**
         * @OA\Property(ref="#/components/schemas/department")
         */
        public $department;

        /**
         * @OA\Property(ref="#/components/schemas/position")
         */
        public Position $position;

        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property()
         */
        public bool $is_online;

        /**
         * @OA\Property()
         */
        public bool $has_social_support;

        /**
         * @OA\Property()
         */
        public string $schedule;

        /**
         * @OA\Property()
         */
        public bool $is_flexible;

        /**
         * @OA\Property()
         */
        public string $link_to_test_document;

        /**
         * @OA\Property(ref="#/components/schemas/city")
         */
        public City $city;

        /**
         * @OA\Property()
         */
        public bool $is_closed;

        /**
         * @OA\Property()
         */
        public bool $is_outer;

        /**
         * @OA\Property()
         */
        public string $responsibilities;

        /**
         * @OA\Property()
         */
        public string $requirements;

        /**
         * @OA\Property()
         */
        public string $conditions;

        /**
         * @OA\Property()
         */
        public ?string $additional;

        /**
         * @OA\Property(ref="#/components/schemas/experience")
         */
        public Experience $experience;

        /**
         * @OA\Property(ref="#/components/schemas/employment")
         */
        public Employment $employment;

        /**
         * @OA\Property()
         */
        public ?float $lower_salary;

        /**
         * @OA\Property()
         */
        public ?float $higher_salary;

        /**
         * @OA\Property()
         */
        public ?int $image_id;
    }

    /** @OA\Schema(schema="detailVacancy") */
    class DetailVacancy extends Vacancy
    {
        /**
         * @OA\Property(ref="#/components/schemas/specialization")
         */
        public Specialization  $specialization;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/skill"))
         */
        public $skills;
    }

    /** @OA\Schema(schema="HRPanelVacancy") */
    class HRPanelVacancy extends Vacancy
    {
        /**
         * @OA\Property(ref="#/components/schemas/HR")
         */
        public HR $accountable;

        /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/skill"))
         */
        public $skills;

        /**
         * @OA\Property(ref="#/components/schemas/specialization")
         */
        public Specialization  $specialization;
    }

    /** @OA\Schema(schema="department") */
    class Department extends BaseClass
    {
        /**
         * @OA\Property(ref="#/components/schemas/company")
         */
        public $company;
    }

    /** @OA\Schema(schema="detailDepartment") */
    class DetailDepartment extends Department
    {
        /**
         * @OA\Property(ref="#/components/schemas/detailCompany")
         */
        public $company;
    }

    /** @OA\Schema(schema="detailCompany") */
    class DetailCompany extends Company
    {
      /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $preview;

        /**
         * @OA\Property(ref="#/components/schemas/building")
         */
        public Building $building;

    }

    /** @OA\Schema(schema="company") */
    class Company extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property(format="date")
         */
        public $established_at;

        /**
         * @OA\Property()
         */
        public string $nick_name;

        /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

        /**
         * @OA\Property()
         */
        public ?int $building_id;

    }

    /** @OA\Schema(schema="building") */
    class Building extends BaseClass
    {
        /**
         * @OA\Property(ref="#/components/schemas/street")
         */
        public Street $street;
    }

    /** @OA\Schema(schema="street") */
    class Street extends BaseClass
    {
        /**
         * @OA\Property(ref="#/components/schemas/detailCity")
         */
        public DetailCity $city;
    }

    /** @OA\Schema(schema="skill") */
    class Skill
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $name;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="city") */
    class City
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $name;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

        /**
         * @OA\Property()
         */
        public ?int $country_id;
    }

    /** @OA\Schema(schema="detailCity") */
    class DetailCity extends City
    {
        /**
         * @OA\Property(ref="#/components/schemas/country")
         */
        public Country $country;
    }

    /** @OA\Schema(schema="country") */
    class Country extends BaseClass
    {
    }

    /** @OA\Schema(schema="image") */
    class Image extends BaseClass
    {

        /**
         * @OA\Property()
         */
        public string $image;

        /**
         * @OA\Property()
         */
        public string $description;
    }

    /** @OA\Schema(schema="file") */
    class File extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $file;

        /**
         * @OA\Property()
         */
        public string $mime;
    }

    /** @OA\Schema(schema="position") */
    class Position extends BaseClass
    {
    }

    /** @OA\Schema(schema="sources") */
    enum Source
    {
        case venari;
        case habr;
    }

    /** @OA\Schema(schema="post") */
    class Post extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $comment_count;

        /**
         * @OA\Property()
         */
        public string $title;


        /**
         * @OA\Property()
         */
        public string $text;

         /**
         * @OA\Property()
         */
        public bool $is_from_company;

        /**
         * @OA\Property()
         */
        public DetailUser $user;

        /**
         * @OA\Property(ref="#/components/schemas/attributes")
         */
        public string $attributes;

        /**
         * @OA\Property()
         */
        public int $likes;

        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property(ref="#/components/schemas/sources")
         */
        public Source $source;

        /**
         * @OA\Property()
         */
        public string $user_name;

        /**
         * @OA\Property(format="url")
         */
        public string $source_url;

       /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/image"))
         */
        public $images;
    }

    /** @OA\Schema(schema="detailPost") */
    class DetailPost extends Post
    {
        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/detailComment"))
         */
        public $comments;
    }

    /** @OA\Schema(schema="attributes") */
    class Attributes
    {

    }

    /** @OA\Schema(schema="user") */
    class User extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $email;

        /**
         * @OA\Property()
         */
        public int $workingStatus_id;

        /**
         * @OA\Property()
         */
        public int $position_id;

      /**
         * @OA\Property()
         */
        public string $first_name;

        /**
         * @OA\Property()
         */
        public string $last_name;

        /**
         * @OA\Property()
         */
        public bool $sex;

        /**
         * @OA\Property(format="date")
         */
        public $date_of_birth;

        /**
         * @OA\Property()
         */
        public ?int $hrable_id;

        /**
         * @OA\Property()
         */
        public string $hrable_type;

        /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

      /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $preview;

        /**
         * @OA\Property(ref="#/components/schemas/company")
         */
        public Company $company;
    }

    /** @OA\Schema(schema="evenMoreDetailUser") */
    class EvenMoreDetailUser extends User
    {
        /**
         * @OA\Property()
         */
        public DetailCity $city;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/applicationTag"))
         */
        public $tags;
    }

    /** @OA\Schema(schema="userWithResume") */
    class UserWithResume extends EvenMoreDetailUser
    {
        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/resume"))
         */
        public $resumes;
    }

    /** @OA\Schema(schema="previewChat") */
    class PreviewChat
    {
        /**
         * @OA\Property()
         */
        public string $name;

        /**
         * @OA\Property()
         */
        public string $avatar;

        /**
         * @OA\Property()
         */
        public string $body;

        /**
         * @OA\Property(format="date")
         */
        public string $updated_at;

        /**
         * @OA\Property(description="Тип чата. Необходим для определения того, откуда получать данные в ChatController")
         */
        public MessageType $type;

        /**
         * @OA\Property(description="'id может быть как чата, так и пользователя. Смотри type")
         */
        public int $id;
    }

    /** @OA\Schema(schema="message") */
    class Message extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $from_id;

        /**
         * @OA\Property()
         */
        public int $to_id;

        /**
         * @OA\Property()
         */
        public string $body;
    }

    /** @OA\Schema(schema="chatMessage") */
    class ChatMessage extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $owner_id;

        /**
         * @OA\Property()
         */
        public int $chat_id;

        /**
         * @OA\Property()
         */
        public string $body;
    }

    /** @OA\Schema(schema="comment") */
    class Comment extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $text;

        /**
         * @OA\Property()
         */
        public int $post_id;

        /**
         * @OA\Property(description="id комментария, на который отвечаем")
         */
        public ?int $parent_id;
    }

    /** @OA\Schema(schema="detailComment") */
    class DetailComment extends Comment
    {
        /**
         * @OA\Property(ref="#/components/schemas/detailUser")
         */
        public DetailUser $user;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/detailComment"))
         */
        public $all_children;
    }

    /** @OA\Schema(schema="detailUser") */
    class DetailUser extends User
    {
        /**
         * @OA\Property()
         */
        public DetailHR $hrable;
    }

    /** @OA\Schema(schema="HR") */
    class HR extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $company_id;
    }

    /** @OA\Schema(schema="detailHR") */
    class DetailHR extends HR
    {
        /**
         * @OA\Property()
         */
        public Company $company;
    }

    /** @OA\Schema(schema="hrWithUser") */
    class HRWithUser extends HR
    {
        /**
         * @OA\Property()
         */
        public User $user;
    }

    /** @OA\Schema(schema="chat") */
    class Chat extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property()
         */
        public int $member_count;

        /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/tag"))
         */
        public $tags;
    }

    /** @OA\Schema(schema="tag") */
    class Tag extends BaseClass
    {
    }

    /** @OA\Schema(schema="filter") */
    class Filter
    {
        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/status"))
         */
        public $statuses;


        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/employment"))
         */
        public $employments;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/experience"))
         */
        public $experiences;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/format"))
         */
        public $formats;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/specialization"))
         */
        public $specializations;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/department"))
         */
        public $departments;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/hrWithUser"))
         */
        public $accountables;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/programType"))
         */
        public  $program_types;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/stage"))
         */
        public  $stages;
    }


    /** @OA\Schema(schema="status") */
    class Status extends BaseClass
    {

    }

    /** @OA\Schema(schema="employment") */
    class Employment extends BaseClass
    {

    }

    /** @OA\Schema(schema="experience") */
    class Experience extends BaseClass
    {

    }

    /** @OA\Schema(schema="format") */
    class Format extends BaseClass
    {

    }

    /** @OA\Schema(schema="specialization") */
    class Specialization extends BaseClass
    {

    }

    /** @OA\Schema(schema="resume") */
    class Resume extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property()
         */
        public int $user_id;

        /**
         * @OA\Property()
         */
        public string $contact_phone;

        /**
         * @OA\Property()
         */
        public string $contact_mail;

        /**
         * @OA\Property()
         */
        public string $salary;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/resumeProgramSchool"))
         */
        public $resumeProgramSchools;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/userPosition"))
         */
        public $userPositions;

        /**
         * @OA\Property()
         */
        public Employment $employment;

        /**
         * @OA\Property()
         */
        public Specialization $specialization;

        /**
         * @OA\Property()
         */
        public Position $position;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/languageLevel"))
         */
        public $languageLevel;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/skill"))
         */
        public $skills;

        /**
         * @OA\Property()
         */
        public Format $format;

    }

    /** @OA\Schema(schema="evenMoreDetailResume") */
    class EvenMoreDetailResume extends Resume
    {

        /**
         * @OA\Property()
         */
        public EvenMoreDetailUser $user;

    }

    /** @OA\Schema(schema="notSoDetatilResume") */
    class NotSoDetatilResume extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property()
         */
        public User $user;

        /**
         * @OA\Property()
         */
        public string $contact_phone;

        /**
         * @OA\Property()
         */
        public string $contact_mail;

        /**
         * @OA\Property()
         */
        public string $salary;

    }

    /** @OA\Schema(schema="languageLevel") */
    class LanguageLevel extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public Language $language;

        /**
         * @OA\Property()
         */
        public Level $level;

    }

    /** @OA\Schema(schema="resumeProgramSchool") */
    class ResumeProgramSchool extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public ProgramSchool $programSchool;

        /**
         * @OA\Property(format="date")
         */
        public $start_date;

        /**
         * @OA\Property(format="date")
         */
        public $end_date;


    }

    /** @OA\Schema(schema="userPosition") */
    class UserPosition extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public Company $company;

        /**
         * @OA\Property()
         */
        public Position $position;

        /**
         * @OA\Property(format="date")
         */
        public $start_date;

        /**
         * @OA\Property(format="date")
         */
        public $end_date;

        /**
         * @OA\Property()
         */
        public string $description;

    }

    /** @OA\Schema(schema="programSchool") */
    class ProgramSchool extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public Program $program;

        /**
         * @OA\Property()
         */
        public School $school;

    }

    /** @OA\Schema(schema="program") */
    class Program extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public ProgramType $programType;

    }

    /** @OA\Schema(schema="programType") */
    class ProgramType extends BaseClass {}

    /** @OA\Schema(schema="school") */
    class School extends BaseClass {}

    /** @OA\Schema(schema="language") */
    class Language extends BaseClass {}

    /** @OA\Schema(schema="level") */
    class Level extends BaseClass {}

    /** @OA\Schema(schema="stage") */
    class Stage extends BaseClass {
        /**
         * @OA\Property()
         */
        public StageType $stageType;
    }

    /** @OA\Schema(schema="stageType") */
    class StageType extends BaseClass {}

    /** @OA\Schema(schema="application") */
    class Application extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public NotSoDetatilResume $resume;

    }

    /** @OA\Schema(schema="detailApplication") */
    class DetailApplication extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public EvenMoreDetailResume $resume;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/applicationComment"))
         */
        public $comments;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/approve"))
         */
        public $approves;
    }

    /** @OA\Schema(schema="applicationComment") */
    class ApplicationComment extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $text;

        /**
         * @OA\Property()
         */
        public User $user;

        /**
         * @OA\Property()
         */
        public int $application_id;
    }

    /** @OA\Schema(schema="applicationTag") */
    class ApplicationTag extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public int $company_id;

    }

    /** @OA\Schema(schema="approve") */
    class Approve extends BaseClass
    {
        /**
         * @OA\Property()
         */
        public string $surname;

        /**
         * @OA\Property()
         */
        public int $application_id;

        /**
         * @OA\Property()
         */
        public bool $status_id;

    }

}
