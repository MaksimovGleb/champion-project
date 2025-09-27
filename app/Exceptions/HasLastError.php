<?php

namespace App\Exceptions;

class HasLastError
{
    protected string $errorText = '';
    protected string $traces = '';

    public function getLastError(): string
    {
        return $this->errorText;
    }

    public function getTraces(): string
    {
        return $this->traces;
    }

    protected function setLastError(string $errorText)
    {
        return $this->errorText = $errorText;
    }

    protected function setTraces(string $traces)
    {
        return $this->traces = $traces;
    }

}
