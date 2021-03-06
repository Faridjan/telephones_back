<?php

namespace App\Http\Middleware\Cookie;

use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CookieResponseMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $responseFromHandler = $handler->handle($request);

        $oauthData = $responseFromHandler->getHeaderLine('oauth');

        if (!empty($oauthData)) {
            $responseFromHandler = $responseFromHandler->withoutHeader('oauth');
        }

        return FigResponseCookies::set(
            $responseFromHandler,
            SetCookie::create('oauth')
                ->withValue($oauthData ?? '')
                ->withPath('/')
        );
    }
}
