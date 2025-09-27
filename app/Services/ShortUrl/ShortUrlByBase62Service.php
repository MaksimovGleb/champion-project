<?php

namespace App\Services\ShortUrl;

use App\Services\Interfaces\ShortUrl\ShortUrlServiceInterface;
use Tuupola\Base62;

class ShortUrlByBase62Service implements ShortUrlServiceInterface
{
    protected $base62;

    private $offset;

    private $separator = '|';

    public function __construct()
    {
        $this->base62 = new Base62();
        $this->offset = 10;
    }

    public function toUrl(int $userId)
    {
        return $this->base62->encode($userId + $this->offset);
    }

    public function fromUrl(string $url)
    {
        return $this->base62->decode($url) - $this->offset;
    }

    public function dualToUrl(int $salerId, int $certId)
    {
        return $this->base62->encode(($salerId + $this->offset).$this->separator.($certId + $this->offset));
    }

    public function dualFromUrl(string $url)
    {
        if (($data = explode($this->separator, $this->base62->decode($url))) && count($data) == 2) {
            return [
                'saler_id' => $data[0] - $this->offset,
                'cert_id' => $data[1] - $this->offset,
            ];
        }

        return false;
    }
}
