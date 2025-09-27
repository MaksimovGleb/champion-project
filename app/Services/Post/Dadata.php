<?php

namespace App\Services\Post;

use App\Services\Interfaces\Post\TstInterface;
use GuzzleHttp\Client;

class Dadata implements TstInterface
{
    public const BASE_URL = 'https://dadata.ru/api/v2/';

    public const TIMEOUT_SEC = 10;

    protected $client;

    protected $message = '';

    public function __construct()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token '.config('dadata.token'),
        ];
        if (($secret = config('dadata.secret'))) {
            $headers['X-Secret'] = $secret;
        }
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => $headers,
            'timeout' => self::TIMEOUT_SEC,
        ]);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function test(): bool
    {
        try {
            $response = $this->client->get('profile/balance');
        } catch(\Exception $exception) {
            $this->message = $exception->getMessage();

            return false;
        }

        if (($result = json_decode($response->getBody(), true)) && $result['balance'] && $result['balance'] > 0) {
            return true;
        }

        $this->message = 'Необходимо пополнить баланс.';

        return false;
    }
}
