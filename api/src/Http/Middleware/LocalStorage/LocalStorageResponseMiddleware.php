<?php

declare(strict_types=1);

namespace App\Http\Middleware\LocalStorage;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocalStorageResponseMiddleware implements MiddlewareInterface
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
            $arrOauthData = json_decode($oauthData, true);
            $responseFromHandler = $responseFromHandler->withoutHeader('oauth');

            if (isset($arrOauthData['access_token'])) {
                $responseFromHandler = $responseFromHandler
                    ->withAddedHeader('X-Satrap-1', $arrOauthData['access_token'] ?? '');
            }

            if (isset($arrOauthData['refresh_token'])) {
                $responseFromHandler = $responseFromHandler
                    ->withAddedHeader('X-Satrap-2', $arrOauthData['refresh_token'] ?? '');
            }
        }

        return $responseFromHandler;
    }
}
