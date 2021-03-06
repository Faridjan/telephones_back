<?php


namespace App\Http\Action\V1\Content;


use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Content\Command\Content\Command;
use App\ReadModel\Content\ContentFetcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContentAction implements RequestHandlerInterface
{
    private ContentFetcher $fetcher;
    private Validator $validator;

    /**
     * CityAction constructor.
     * @param ContentFetcher $fetcher
     * @param Validator $validator
     */
    public function __construct(ContentFetcher $fetcher, Validator $validator)
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

        $arrCity = $this->fetcher->getContentById($command);

        return new JsonResponse($arrCity);
    }
}