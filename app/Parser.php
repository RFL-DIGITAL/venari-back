<?php

namespace App;

use Illuminate\Support\Facades\Http;

class Parser
{
    /**
     * Считывает html-страницу в строку
     *
     * Необходим для  дальнейшего парсинга
     */
    public static function getDocument(string $url): bool|string
    {
        $result = Http::get($url)->body();

        return $result;
    }
}
