<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Proxy;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Model\Proxy\Command\Logout\Command;
use App\Infrastructure\Model\Proxy\Command\Logout\Handler;
use App\Infrastructure\Symfony\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutAction implements RequestHandlerInterface
{
    private Validator $validator;
    private Handler $handler;

    public function __construct(Validator $validator, Handler $handler)
    {
        $this->validator = $validator;
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $command->accessToken = $request->getHeaderLine('X-Satrap-1') ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
