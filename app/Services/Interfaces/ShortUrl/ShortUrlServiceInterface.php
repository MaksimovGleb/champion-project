<?php

namespace App\Services\Interfaces\ShortUrl;

interface ShortUrlServiceInterface
{
    public function toUrl(int $userId);
    public function fromUrl(string $url);
}
