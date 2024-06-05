<?php
/** @noinspection ALL */
// @formatter:off

namespace Responses {

    use Faker\Core\DateTime;use OpenApi\Annotations as OA;

    /** @OA\Schema(schema="vacancy") */
    class Vacancy
    {
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
         * @OA\Property()
         */
        public string $created_at;

        /**
         * @OA\Property()
         */
        public string $updated_at;
    }

    /** @OA\Schema(schema="position") */
    class Position
    {
        /**
         * @OA\Property()
         */
        public string $name;

        /**
         * @OA\Property()
         */
        public string $created_at;

        /**
         * @OA\Property()
         */
        public string $updated_at;

    }
}
