<?php


namespace App\Http\Action\V1\Mark;


use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Mark\Command\Remove\Command;
use App\Model\Mark\Command\Remove\Handler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MarkRemoveAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    /**
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
        $data = $request->getQueryParams();

        $id = $data['id'] ?? '';

        $command = new Command();
        $command->id = $id;

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
