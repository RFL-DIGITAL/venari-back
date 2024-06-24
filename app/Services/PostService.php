<?php

namespace App\Services;

use App\Helper;
use App\Models\Heading;
use App\Models\Image;
use App\Models\ImageBlock;
use App\Models\Part;
use App\Models\Category;
use App\Models\Post;
use App\Models\Text;
use App\Models\Title;
use App\Models\User;
use App\Parser;
use Illuminate\Database\Eloquent\Builder;
use phpQuery;
use Naxon\UrlUploadedFile\UrlUploadedFile;


class PostService
{
    private const HABR_RSS_LINK = 'https://habr.com/ru/rss/news/?fl=ru';
    private const HABR_USER_ID = 33;


    public function getInnerPosts(?string $search = null): array
    {

        if ($search) {
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
                $foundPost->load([
                    'user.image',
                    'user.hrable.company.image',
                    'images',
                    'parts'
                ]);
                $posts[] = $foundPost->toArray();
                continue;
            }

            $post = new Post();
            $post->title = $title;
            $post->user_name = $user_name;
            $post->source_url = (string)$item->guid;

            $post->description =
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
                                preg_replace('/<img\s+[^>]*src="([^"]*)"[^>]*>/', '', (string)$item->description))
                        )));

            $detailPostPage = Parser::getDocument((string)$item->guid);
            $pq = phpQuery::newDocument($detailPostPage);

            $postText = $pq->find('#post-content-body p')->text();

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

            $order = 1;

            $partModel = new Part();
            $title = new Title();
            $title->name = $post->title;
            $title->save();
            $partModel->content()->associate($title);
            $partModel->post_id = $post->id;
            $partModel->order = $order;
            $partModel->save();
            $order++;

            $isAddedPhotos = false;

            foreach ($pq->find('.article-formatted-body_version-2 div *')->elements as $element) {
                if (pq($element)->is('p')) {
                    $partModel = new Part();
                    $partModel->order = $order;
                    $text = new Text();
                    $text->name = pq($element)->html();
                    $text->save();
                    $partModel->content()->associate($text);
                    $partModel->post_id = $post->id;
                    $partModel->save();
                    $order++;

                } else if (pq($element)->is('img')) {
                    $partModel = new Part();
                    $partModel->order = $order;
                    $image_block = new ImageBlock();
                    $image_block->save();
                    $imageID = Helper::createNewImageModel(
                        file_get_contents(UrlUploadedFile::createFromUrl(
                            pq($element)->attr('src'))
                        ))->id;
                    if (!$isAddedPhotos) {
                        $post->images()->attach($imageID);
                        $isAddedPhotos = true;
                    }
                    $image_block->images()->attach($imageID);
                    $image_block->save();
                    $partModel->content()->associate($image_block);
                    $partModel->post_id = $post->id;
                    $partModel->save();
                    $order++;
                }
                $post->save();
            }

            $post->save();
            $posts[] = $post->load('parts')->toArray();
        }

        return $posts;
    }

    public function getPostByID($id)
    {
        $post = Post::where('id', $id)->first();

        if ($post->is_from_company) {
            $post->load([
                'user.hrable.company.image',
                'images',
                'parts.content',
            ]);

            $post = $post->toArray();

            $parts = [];

            foreach ($post['parts'] as $part) {
                if ($part['content_type'] == 'App\\Models\\ImageBlock') {
                    $part['images'] = Image::whereHas('imageBlocks', function ($query) use ($part) {
                        $query->where('image_block_id', $part['content_id']);
                    })->get()->toArray();
                }
                $parts[] = $part;
            }

            $post['parts'] = $parts;

            return $post;
        } else {
            $post->load([
                'user.image',
                'images',
                'parts.content',
            ]);

            $post = $post->toArray();

            $parts = [];

            foreach ($post['parts'] as $part) {
                if ($part['content_type'] == 'App\\Models\\ImageBlock') {
                    $part['images'] = Image::whereHas('imageBlocks', function ($query) use ($part) {
                        $query->where('image_block_id', $part['content_id']);
                    })->get()->toArray();
                }
                $parts[] = $part;
            }

            $post['parts'] = $parts;
            return $post;
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

    public function createPost(array $post_parts, $category_id, $title): array
    {
        $post = new Post();
        $user = User::where('id', auth()->id())->first();
        $post->user_id = $user->id;
        $post->user_name = $user->user_name;
        $post->title = $title;
        $post->categories()->attach($category_id);

        foreach ($post_parts as $part) {
            $partModel = new Part();
            $partModel->order = $part['order'];
            $isAddedText = false;
            $isAddedPhotos = false;

            switch ($part['type']) {
                case 'title':
                    $title = new Title();
                    $title->name = $part['content'];
                    $title->save();
                    $partModel->content()->associate($title);
                    break;
                case 'text':
                    $text = new Text();
                    $text->name = $part['content'];
                    $text->save();
                    $partModel->content()->associate($text);
                    if (!$isAddedText) {
                        $post->text = $text->name;
                        $isAddedText = true;
                    }
                    break;
                case 'heading':
                    $heading = new Heading();
                    $heading->name = $part['content'];
                    $heading->save();
                    $partModel->content()->associate($heading);
                    break;
                case 'image_block':
                    $image_block = new ImageBlock();
                    foreach ($part['content'] as $image) {
                        $imageID = Helper::createNewImageModel($image)->id;
                        if (!$isAddedPhotos) {
                            $post->images()->attach($imageID);
                            $isAddedPhotos = true;
                        }
                        $image_block->images()->attach($imageID);
                    }
                    $image_block->save();
                    $partModel->content()->associate($image_block);
                    break;
            }
            $post->save();
            $partModel->post_id = $post->id;
            $partModel->save();
        }

        return ['message' => 'Post created successfully'];
    }
}
