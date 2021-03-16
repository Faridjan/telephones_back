<?php

namespace App\Http\Action\V1\Mark;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Mark\Command\Update\Command;
use App\Model\Mark\Command\Update\Handler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MarkUpdateAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    /**
     * UserUpdateAction constructor.
     * @param Handler $handler
     * @param Validator $validator
     */
    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $id = $data['id'] ?? '';
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? '';
        $coordinates = $data['coordinates'] ?? null;
        $options = $data['options'] ?? null;

        $command = new Command();
        $command->id = $id;
        $command->name = $name;
        $command->description = $description;
        $command->coordinates = $coordinates;
        $command->options = $options;

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([], 200);
    }
}
