<?php

use App\Http\Middleware\AdminViewAuth;
use App\Http\Middleware\AdminViewUnAuth;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\UserViewAuth;
use App\Http\Middleware\UserViewUnAuth;
use App\Http\Middleware\VendorViewAuth;
use App\Http\Middleware\VendorViewUnAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
         // This is good method to pass data with middleware 
         $middleware->alias([

            'AdminViewAuth'=>AdminViewAuth::class,
            'AdminViewUnAuth'=>AdminViewUnAuth::class,
            'UserViewAuth'=>UserViewAuth::class,
            'UserViewUnAuth'=>UserViewUnAuth::class,
            'VendorViewAuth'=>VendorViewAuth::class,
            'VendorViewUnAuth'=>VendorViewUnAuth::class,
            'setlocale'=>SetLocale::class

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
