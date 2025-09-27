<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ParserApiService
{
    protected $key;

    protected $url;

    public $subUrl = 'parser/arbitr_api/run.php';

    public $getInput;

    public $search;

    public $page;

    public $Inn;

    public $DateFrom;

    public $DateTo;

    public $Court;

    public function __construct()
    {
        $this->url = config('parser-api.api_url');
        $this->key = config('parser-api.api_key');
        $this->getInput = [
            'key' => $this->key,
        ];
    }

    public function getStat()
    {
        return self::getApiData([], 'stat/')[0];
    }

    public function getApiData(array $getInput = [], string $subUrl = '')
    {
        if ($subUrl === '') {
            $subUrl = $this->subUrl;
        }

        if ($getInput === []) {
            $getInput = $this->getInput;
        } else {
            $getInput = array_merge([
                'key' => $this->key,
            ], $getInput);
        }

        $response = Http::get($this->url.$subUrl, $getInput);

        return $response->ok() ? $response->json() : false;
    }
}
