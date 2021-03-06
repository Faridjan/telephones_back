<?php

namespace App\Http\Middleware\Cookie;

use App\Http\Response\JsonResponse;
use Dflydev\FigCookies\FigRequestCookies;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CookieRequestMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookieFromRequest = FigRequestCookies::get($request, 'oauth');

        if (!isset($cookieFromRequest) || empty($cookieFromRequest->getValue())) {
            return new JsonResponse(
                [
                    'message' => 'Access denied. Cookie oauth not set.'
                ],
                400
            );
        }

        return $handler->handle($request->withAttribute('oauth', $cookieFromRequest->getValue()));
    }
}
