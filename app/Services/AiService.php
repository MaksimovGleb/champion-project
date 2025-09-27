<?php

namespace App\Services;

use App\Contracts\Services\AiProviderInterface;

final class AiService implements AiProviderInterface
{
    private AiProviderInterface $service;

    public function __construct()
    {
        $this->service = app()->make(AiProviderInterface::class);
//        dd($this->service);
    }

    public function ask(string $message, array $history = []): string
    {
        return $this->service->ask($message);
    }
}
