<?php

declare(strict_types=1);

namespace App\Http\Middleware\Catchers\Sentry;

use App\Infrastructure\Sentry\SentryClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class SentryExceptionMiddleware implements MiddlewareInterface
{
    private SentryClient $sentryHelper;

    /**
     * SentryExceptionMiddleware constructor.
     * @param SentryClient $sentryHelper
     */
    public function __construct(SentryClient $sentryHelper)
    {
        $this->sentryHelper = $sentryHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            if ($this->sentryHelper->isProduction()) {
                $this->sentryHelper->pushException($exception);
            }
            throw $exception;
        }
    }
}
