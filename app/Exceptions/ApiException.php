<?php

namespace App\Exceptions;

use RuntimeException;

class ApiException extends RuntimeException
{
    public function __construct(protected int $apiCode = 0, string|null $message = null)
    {
        parent::__construct(is_null($message)
            ? 'Too many request attempts. Please try again in -1 seconds.'
            : $message
        );
    }

    public function getApiCode(): int
    {
        return $this->apiCode;
    }
}
