<?php


namespace App\Http\Action\V1\Mark;


use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Mark\Command\Mark\Command;
use App\ReadModel\Mark\MarkFetcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MarkAction implements RequestHandlerInterface
{
    private MarkFetcher $fetcher;
    private Validator $validator;

    /**
     * CityAction constructor.
     * @param MarkFetcher $fetcher
     * @param Validator $validator
     */
    public function __construct(MarkFetcher $fetcher, Validator $validator)
    {
        $this->fetcher = $fetcher;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @psalm-var array{id:?string} $data
         */
        $data = $request->getQueryParams();

        $uuid = $data['id'] ?? '';

        $command = new Command();
        $command->id = $uuid;

        $this->validator->validate($command);

        $arrCity = $this->fetcher->getMarkById($command);

        return new JsonResponse($arrCity);
    }
}
