<?php

namespace App;

class Parser
{
    /**
     * Считывает html-страницу в строку
     *
     * Необходим для  дальнейшего парсинга
     */
    public static function getDocument(string $url): bool|string
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
