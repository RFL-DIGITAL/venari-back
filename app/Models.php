<?php
/** @noinspection ALL */

// @formatter:off

namespace Responses {

    use App\DTO\MessageType;
    use OpenApi\Annotations as OA;

    /** @OA\Schema(schema="vacancy") */
    class Vacancy
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property(ref="#/components/schemas/department")
         */
        public Department $department;

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
    class DetailVacancy
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property(ref="#/components/schemas/detailDepartment")
         */
        public DetailDepartment $department;

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
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/skill"))
         */
        public $skills;
    }

    /** @OA\Schema(schema="detailDepartment") */
    class DetailDepartment
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
         * @OA\Property(ref="#/components/schemas/detailCompany")
         */
        public DetailCompany $company;
    }

    /** @OA\Schema(schema="department") */
    class Department
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
         * @OA\Property(ref="#/components/schemas/company")
         */
        public Company $company;
    }

    /** @OA\Schema(schema="detailCompany") */
    class DetailCompany
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
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

        /**
         * @OA\Property(ref="#/components/schemas/image")
         */
        public Image $image;

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
    class Company
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
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

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
    class Building
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
         * @OA\Property(ref="#/components/schemas/street")
         */
        public Street $street;
    }

    /** @OA\Schema(schema="street") */
    class Street
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
    class DetailCity
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
         * @OA\Property(ref="#/components/schemas/country")
         */
        public Country $country;
    }

    /** @OA\Schema(schema="country") */
    class Country
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

    /** @OA\Schema(schema="image") */
    class Image
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $image;

        /**
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

    }

    /** @OA\Schema(schema="file") */
    class File
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $file;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

    }

    /** @OA\Schema(schema="position") */
    class Position
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

    /** @OA\Schema(schema="employment") */
    class Employment
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

    /** @OA\Schema(schema="experience") */
    class Experience
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

    /** @OA\Schema(schema="sources") */
    enum Source
    {
        case venari;
        case habr;
    }

    /** @OA\Schema(schema="post") */
    class Post
    {
        /**
         * @OA\Property()
         */
        public int $id;

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
         * @OA\Property()
         */
        public bool $is_from_company;

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
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/image"))
         */
        public $images;
    }

    /** @OA\Schema(schema="detailPost") */
    class DetailPost
    {
        /**
         * @OA\Property()
         */
        public int $id;

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
         * @OA\Property(ref="#/components/schemas/detailUser")
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
         * @OA\Property()
         */
        public bool $is_from_company;

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
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/image"))
         */
        public $images;
    }

    /** @OA\Schema(schema="attributes") */
    class Attributes
    {

    }

    /** @OA\Schema(schema="user") */
    class User
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
        public string $email;

        /**
         * @OA\Property()
         */
        public int $workingStatus_id;

        /**
         * @OA\Property(ref="#/components/schemas/position")
         */
        public Position $position;

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

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="previewChat") */
    class PreviewChat {
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
    class Message
    {
        /**
         * @OA\Property()
         */
        public int $id;

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

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="chatMessage") */
    class ChatMessage
    {
        /**
         * @OA\Property()
         */
        public int $id;

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

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="comment") */
    class Comment
    {
        /**
         * @OA\Property()
         */
        public int $id;

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

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="detailComment") */
    class DetailComment
    {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public string $text;

        /**
         * @OA\Property()
         */
        public ?int $post_id;

        /**
         * @OA\Property(ref="#/components/schemas/detailUser")
         */
        public DetailUser $user;

        /**
         * @OA\Property(type="array", @OA\Items(ref="#/components/schemas/comment"), description="Массив ответов")
         */
        public $all_children;

        /**
         * @OA\Property(description="id комментария, на который отвечаем")
         */
        public ?int $parent_id;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="detailUser") */
    class DetailUser
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
        public bool $sex;

        /**
         * @OA\Property(format="date")
         */
        public $date_of_birth;

        /**
         * @OA\Property()
         */
        public DetailHR $hrable;

        /**
         * @OA\Property()
         */
        public Image $image;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="HR") */
    class HR {

        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public int $company_id;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

    }

    /** @OA\Schema(schema="detailHR") */
    class DetailHR {
        /**
         * @OA\Property()
         */
        public int $id;

        /**
         * @OA\Property()
         */
        public Company $company;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="chat") */
    class Chat
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
         * @OA\Property()
         */
        public string $description;

        /**
         * @OA\Property()
         */
        public int $member_count;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;

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
    class Tag
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
         * @OA\Property()
         */
        public int $member_count;

        /**
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }
}
