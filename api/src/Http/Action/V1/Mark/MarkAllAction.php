<?php

namespace App\Http\Action\V1\Mark;

use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\Validator;
use App\Model\Mark\Command\All\Command;
use App\ReadModel\Mark\MarkFetcher;
use App\ReadModel\Pagination;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MarkAllAction implements RequestHandlerInterface
{
    private const PER_PAGE = 10;

    private MarkFetcher $fetcher;
    private Validator $validator;

    /**
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
        $data = $request->getQueryParams();

        $page = $data['p'] ?? 1;
        $limit = $data['limit'] ?? null;
        $offset = $data['offset'] ?? null;

        $command = new Command();
        $command->page = $page;
        $command->limit = $limit;
        $command->offset = $offset;

        $this->validator->validate($command);

        $countAll = $this->fetcher->countAll();

        $pager = new Pagination(
            $countAll,
            $command->page,
            $command->limit = $command->limit ?? self::PER_PAGE
        );

        $command->offset = $command->offset ?? $pager->getOffset();

        $cities = $this->fetcher->getAll($command);

        return new JsonResponse(
            [
                'page' => $pager->getPage(),
                'count' => $pager->getPagesCount(),
                'per_page' => $pager->getLimit(),
                'data' => $cities,
            ]
        );
    }
}
