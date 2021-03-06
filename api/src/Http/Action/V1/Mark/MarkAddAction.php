<?php


namespace App\Http\Action\V1\Mark;


use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
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
        /**
         * @psalm-var array{
         *      name_ru:?string
         *      name_en:?string
         *      region_id:?string
         * } $data
         */
        $data = $request->getParsedBody();

        $nameRu = $data['name_ru'] ?? '';
        $nameEn = $data['name_en'] ?? '';
        $regionId = $data['region_id'] ?? '';
        $zoneId = $data['zone_id'] ?? '';
        $type = $data['type'] ?? CityType::CITY;
        $central = isset($data['central']) ? StrBoolHelper::getBoolOrString($data['central']) : null;

        $command = new Command();
        $command->nameRu = $nameRu;
        $command->nameEn = $nameEn;
        $command->regionId = $regionId;
        $command->zoneId = $zoneId;
        $command->type = $type;
        $command->central = $central;

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([], 200);
    }
}