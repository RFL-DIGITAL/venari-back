<?php

namespace App\Services;

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Parser;
use phpQuery;
use SimpleXMLElement;

class PostService
{
    private string $HABR_RSS_LINK = 'https://habr.com/ru/rss/news/?fl=ru';
    private string $SYMBOLS_TO_ESCAPE = ' \n\r\t\v\x00';


    public function getInnerPosts(): array
    {
        $posts = Post::all();

        return $posts->toArray();
    }

    public function getOuterPosts(int $postCount): array
    {
        $xml = simplexml_load_file($this->HABR_RSS_LINK.'&limit='.$postCount,
            'SimpleXMLElement',
            LIBXML_NOCDATA);

        $posts = [];

        foreach ($xml->channel->item as $item) {
            $title = (string) $item->title;
            $user_name = (string) $item->children('dc', true)
                ->creator;

            $foundPost = Post::where('title', $title)
                ->where('user_name', $user_name)
                ->first();


            if ($foundPost != null)
            {
                $posts[] = $foundPost->toArray();
                continue;
            }

            $post = new Post();
            $post->title = $title;
            $post->user_name = $user_name;
            $post->source_url = (string) $item->guid;
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
                            (string) $item->description)
                    )))));

            $detailPostPage = Parser::getDocument((string) $item->guid);
            $pq = phpQuery::newDocument($detailPostPage);

            $postText = $pq->find('.tm-article-body')->text();

            $post->text = trim($postText);
            $post->source = 'habr';
            $post->save();
            $post->refresh();

            $posts[] = $post->toArray();
        }

        return $posts;
    }

    public function getPostByID($id)
    {
        return Post::where('id', $id)->first()->toArray();
    }
}
