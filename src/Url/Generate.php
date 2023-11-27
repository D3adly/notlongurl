<?php

declare(strict_types=1);

namespace App\Url;

class Generate
{
    private const SHORT_URL_LENGTH = 5;


    public function generate(int $id, ?int $retry = null): string
    {
        $hash = md5($retry . (string)$id);
        $base64Encoded = base64_encode($hash);
        $shortUrl = preg_replace('/[^a-zA-Z0-9]/', '', $base64Encoded);

        return substr($shortUrl, 0, self::SHORT_URL_LENGTH);
    }
}