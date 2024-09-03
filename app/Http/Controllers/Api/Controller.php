<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = request();
    }
}
