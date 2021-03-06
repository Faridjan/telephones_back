<?php

declare(strict_types=1);

namespace App\Http\Middleware\Catchers;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Proxy\Exception\HttpClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HttpClientExceptionMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpClientException $exception) {
            $msg = json_decode($exception->getMessage(), true);
            return new JsonResponse($msg, $exception->getCode());
        }
    }
}
