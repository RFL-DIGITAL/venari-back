<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Department;
use App\Models\Employment;
use App\Models\Experience;
use App\Models\Position;
use App\Models\Skill;
use App\Models\Vacancy;
use App\Parser;
use Exception;
use phpQuery;


/**
 * Сервис взаимодействия с комментариями
 */
class CommentService
{

    /**
     * Метод создания комментария
     *
     * @param $userID - id пользователя
     * @param $text - текст комментария
     * @param $postID - id поста, которые комментируется
     * @param $parentID - id комментария, на который отвечаем. Необязательный параметр
     * @return array - массив, содержащий созданный комментарий
     */
    public function addComment($userID, $text, $postID, $parentID = null): array
    {
        $comment = new Comment(
            [
                'user_id' => $userID,
                'text' => $text,
                'post_id' => $postID
            ]
        );
        $comment->save();

        $parent = Comment::where('id', $parentID)->first()?->child()->associate($comment);
        $parent?->save();


        return [$comment->toArray()];
    }
}

