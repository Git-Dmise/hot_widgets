<?php

namespace App\Services;

abstract class Service
{
    public function __construct()
    {
        $this->bootstrap();
    }

    protected function bootstrap(): void
    {
        app()->scoped(get_class($this), fn() => $this);
    }
}
