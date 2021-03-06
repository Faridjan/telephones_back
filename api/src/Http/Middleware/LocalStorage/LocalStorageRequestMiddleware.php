<?php

declare(strict_types=1);

namespace App\Http\Middleware\LocalStorage;

use App\Http\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocalStorageRequestMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $satrap1 = $request->getHeaderLine('X-Satrap-1');

        if (empty($satrap1)) {
            return new JsonResponse(
                [
                    'message' => 'Access denied. Header "X-Satrap-1" not set.'
                ],
                400
            );
        }

        return $handler->handle(
            $request->withAttribute(
                'oauth',
                json_encode(['access_token' => $satrap1])
            )
        );
    }
}
