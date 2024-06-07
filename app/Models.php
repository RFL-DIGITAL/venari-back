<?php
/** @noinspection ALL */
// @formatter:off

namespace Responses {

    use App\DTO\MessageType;use Faker\Core\DateTime;use OpenApi\Annotations as OA;

    /** @OA\Schema(schema="vacancy") */
    class Vacancy
    {
        /**
         * @OA\Property()
         */
        public int $id;

        // todo: добавить swagger для сущности depatment
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
        public string $title;


        /**
         * @OA\Property()
         */
        public string $text;

        /**
         * @OA\Property()
         */
        public int $user_id;

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
}
