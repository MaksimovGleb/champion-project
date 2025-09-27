<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        return [
//            'http://127.0.0.1',
//            'https://127.0.0.1',
//            'http://127.0.0.1:8000',
//            'https://127.0.0.1:8000',
//            'http://localhost:8000',
//            'https://localhost:8000',
//            'http://localhost:5173',
//            'https://localhost:5173',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
