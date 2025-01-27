<?php

namespace App\CustomKernel;

use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Tentukan middleware global khusus untuk kernel ini
    protected $middleware = [
        HandleCors::class,
    ];

}
