<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Proxy;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Model\Proxy\Command\Login\Command;
use App\Infrastructure\Symfony\Validator\Validator;
use App\ReadModel\Proxy\JwtFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginAction implements RequestHandlerInterface
{
    private Validator $validator;
    private JwtFetcher $fetcher;

    /**
     * LoginAction constructor.
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
        /**
         * @psalm-var array{
         *      login:?string,
         *      password:?string
         * } $data
         */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->login = $data['login'] ?? '';
        $command->password = $data['password'] ?? '';

        $this->validator->validate($command);


        $encryptedJwt = $this->fetcher->getJwtByLogin($command);

        $response = new JsonResponse([]);

        return $response
            ->withAddedHeader(
                'oauth',
                $encryptedJwt
            );
    }
}
