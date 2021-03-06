<?php

declare(strict_types=1);

use App\Http\Middleware\Catchers\DomainExceptionMiddleware;
use App\Http\Middleware\Catchers\HttpClientExceptionMiddleware;
use App\Http\Middleware\Catchers\Sentry\SentryExceptionMiddleware;
use App\Http\Middleware\ClearEmptyInputMiddleware;
use App\Http\Middleware\UnauthorizedStatusCodeReplaceMiddleware;
use App\Http\Middleware\Catchers\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app): void {
    $app->add(ValidationExceptionMiddleware::class);
    $app->add(DomainExceptionMiddleware::class);
    $app->add(UnauthorizedStatusCodeReplaceMiddleware::class);
    $app->add(ClearEmptyInputMiddleware::class);
    $app->add(HttpClientExceptionMiddleware::class);
    $app->addBodyParsingMiddleware();
    $app->add(SentryExceptionMiddleware::class);
    $app->add(ErrorMiddleware::class);
};
