<?php

declare(strict_types=1);

namespace App\Http\Middleware\Oauth;

use App\Infrastructure\OAuth\JWT\JwtSeparator;
use App\Http\Response\JsonResponse;
use Exception;
use Proxy\OAuth\Interfaces\ConfigStorageInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;
use Proxy\OAuth\Proxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtAccessMiddleware implements MiddlewareInterface
{
    private ConverterInterface $converter;
    private ConfigStorageInterface $configStorage;
    private HttpClientInterface $client;

    public function __construct(
        ConverterInterface $converter,
        ConfigStorageInterface $configStorage,
        HttpClientInterface $client
    ) {
        $this->converter = $converter;
        $this->configStorage = $configStorage;
        $this->client = $client;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $proxy = new Proxy($this->converter, $this->configStorage, $this->client);

        if (!$jwtFromRequest = $request->getAttribute('oauth')) {
            return $this->returnError(new Exception('Access denied. JWT data not sets.', 400));
        }

        try {
            $jwt = $this->converter->fromFrontendToJWT($proxy->check($jwtFromRequest));
        } catch (Exception $e) {
            return $this->returnError(new Exception($e->getMessage(), 400));
        }

        $payload = JwtSeparator::getPayload(json_encode($jwt));
        $userId = $payload['sub'];
        $domainId = $payload['domain_id'];

        $request = $request
            ->withAttribute('oauth_user_id', $userId)
            ->withAttribute('oauth_domain_id', $domainId);

        return $handler->handle($request);
    }

    /**
     * @param Exception $e
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function returnError(Exception $e): ResponseInterface
    {
        return new JsonResponse(
            [
                'message' => $e->getMessage()
            ],
            $e->getCode()
        );
    }
}
