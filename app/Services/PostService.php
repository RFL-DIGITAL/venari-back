<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Parser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use phpQuery;

class PostService
{
    private const HABR_RSS_LINK = 'https://habr.com/ru/rss/news/?fl=ru';
    private const HABR_USER_ID = 33;


    public function getInnerPosts(?string $search = null): array
    {

        if($search) {
            $posts = Post::search($search)->get()->load([
                'user.image',
                'user.hrable.company.image',
                'images',
            ]);
            return $posts->toArray();
        }

        $posts = Post::where('source', 'venari')->get()
            ->load([
                'user.image',
                'user.hrable.company.image',
                'images',
            ]);

        return $posts->toArray();
    }

    public function getOuterPosts(int $postCount): array
    {
        $xml = simplexml_load_file(self::HABR_RSS_LINK . '&limit=' . $postCount,
            'SimpleXMLElement',
            LIBXML_NOCDATA);

        $posts = [];

        foreach ($xml->channel->item as $item) {
            $title = (string)$item->title;
            $user_name = (string)$item->children('dc', true)
                ->creator;

            $foundPost = Post::where('title', $title)
                ->where('user_name', $user_name)
                ->first();


            if ($foundPost != null) {
                $posts[] = $foundPost->toArray();
                continue;
            }

            $post = new Post();
            $post->title = $title;
            $post->user_name = $user_name;
            $post->source_url = (string)$item->guid;
            $post->description =
                strip_tags(
                    str_replace(
                        '&nbsp;',
                        '',
                        str_replace(
                            'Читать далее',
                            '',
                            str_replace(
                                'Читать дальше &rarr;',
                                '',
                                trim(
                                    strip_tags(
                                        (string)$item->description)
                                )))));

            $detailPostPage = Parser::getDocument((string)$item->guid);
            $pq = phpQuery::newDocument($detailPostPage);

            $postText = $pq->find('.tm-article-body')->text();

            $post->text = trim($postText);
            $post->source = 'habr';
            $post->user_id = self::HABR_USER_ID;
            $post->save();
            $post->categories()->attach(Category::where('name', 'Новости')->first()->id);
            $post->load([
                'user.image',
                'user.hrable.company.image',
                'images',
            ]);

            $posts[] = $post->toArray();
        }

        return $posts;
    }

    public function getPostByID($id)
    {
        $post = Post::where('id', $id)->first();

        if ($post->is_from_company) {
            return $post->load([
                'user.hrable.company.image',
                'images',
            ])->toArray();
        } else {
            return $post->load([
                'user.image',
                'images',
            ])->toArray();
        }
    }

    public function getPostByUserID(int $id)
    {
        $post = Post::where('user_id', $id)->where('is_from_company', false)->get()->load(
            [
                'user.image',
                'images',
            ]
        );

        return $post->toArray();
    }

    public function getPostByCompanyID(int $id)
    {
        $post = Post::whereHas('user', function (Builder $query) use ($id) {
            $query->whereHas('hrable', function (Builder $query) use ($id) {
                $query->whereHas('company', function (Builder $query) use ($id) {
                    $query->where('id', $id);
                });
            });
        })->where('is_from_company', true)->get();

        $post->load(
            [
                'user.hrable.company.image',
                'images',
            ]
        );

        return $post->toArray();
    }
}
