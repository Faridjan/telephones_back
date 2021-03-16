<?php

namespace App\Http\Action\V1\Mark;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Mark\Command\Add\Command;
use App\Model\Mark\Command\Add\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MarkAddAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $coordinates = $data['coordinates'] ?? [];
        $options = $data['options'] ?? [];
        $contentJson = $data['content_json'] ?? [];
        $contentHtml = $data['content_html'] ?? null;
        $contentFile = $data['content_file'] ?? null;
        $contentImg = $data['content_img'] ?? null;

        $command = new Command();
        $command->name = $name;
        $command->description = $description;
        $command->coordinates = $coordinates;
        $command->options = $options;
        $command->contentJson = $contentJson;
        $command->contentHtml = $contentHtml;
        $command->contentFile = $contentFile;
        $command->contentImg = $contentImg;

        $this->validator->validate($command);

        $ids = $this->handler->handle($command);

        return new JsonResponse($ids, 200);
    }
}
