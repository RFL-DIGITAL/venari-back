<?php
/** @noinspection ALL */
// @formatter:off

namespace Responses {

    use Faker\Core\DateTime;use OpenApi\Annotations as OA;

    /** @OA\Schema(schema="vacancy") */
    class Vacancy
    {
        // todo: добавить swagger для сущности depatment
        /**
         * @OA\Property()
         */
        public int $department_id;

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
        public string $salary;

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
         * @OA\Property()
         */
        public bool $is_fulltime;

        /**
         * @OA\Property()
         */
        public int $city_id;

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
    }

    /** @OA\Schema(schema="position") */
    class Position
    {
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
        public string $title;


        /**
         * @OA\Property()
         */
        public string $text;

        /**
         * @OA\Property(ref="#/components/schemas/user")
         */
        public User $user;

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
         * @OA\Property(format="date")
         */
        public $created_at;

        /**
         * @OA\Property(format="date")
         */
        public $updated_at;
    }

    /** @OA\Schema(schema="attributes") */
    class Attributes
    {

    }

    /** @OA\Schema(schema="user") */
    class User
    {

    }
}
