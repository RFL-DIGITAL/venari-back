<?php

namespace App\Services;

use App\Models\Comment;


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

        $parent = Comment::where('id', $parentID)->first()?->children()->save($comment);
        $parent?->save();


        return $comment->toArray();
    }

    /**
     * Метод получения всех комментариев поста
     *
     * @param $postID - id поста
     * @return array
     */
    public function getComments($postID): array
    {
        return Comment::where('post_id', $postID)->get()
            ->load('allChildren')
            ->load('user.image')
            ->toArray();
    }
}

