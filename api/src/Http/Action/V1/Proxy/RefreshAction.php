<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Proxy;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Model\Proxy\Command\Refresh\Command;
use App\Infrastructure\Symfony\Validator\Validator;
use App\ReadModel\Proxy\JwtFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RefreshAction implements RequestHandlerInterface
{
    private Validator $validator;
    private JwtFetcher $fetcher;

    /**
     * RefreshAction constructor.
     * @param Validator $validator
     * @param JwtFetcher $fetcher
     */
    public function __construct(Validator $validator, JwtFetcher $fetcher)
    {
        $this->validator = $validator;
        $this->fetcher = $fetcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $command->refreshToken = $request->getHeaderLine('X-Satrap-2') ?? '';

        $this->validator->validate($command);

        $encryptedJwt = $this->fetcher->getJwtByRefreshToken($command);

        $response = new JsonResponse([]);

        return $response
            ->withAddedHeader(
                'oauth',
                $encryptedJwt
            );
    }
}
