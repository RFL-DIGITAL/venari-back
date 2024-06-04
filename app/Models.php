<?php
/** @noinspection ALL */
// @formatter:off

namespace Responses {

    use OpenApi\Annotations as OA;

    /** @OA\Schema(schema="vacancy") */
    class Vacancy
    {
        /**
         * @OA\Property()
         */
        public int $department_id;

        /**
         * @OA\Property()
         */
        public int $position_id;

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
    }
}
