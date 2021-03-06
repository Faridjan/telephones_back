<?php


namespace App\ReadModel\Mark;


use App\Helper\FormatHelper;
use App\Model\Mark\Command\Mark\Command;
use App\Model\Mark\Command\All\Command as CommandAll;
use App\Model\Mark\Command\Find\Command as CommandFind;
use App\Model\Mark\Entity\Mark;
use App\Model\Mark\Entity\MarkRepository;
use App\Model\Type\UUIDType;

class MarkFetcher
{
    private MarkRepository $repository;

    public function __construct(MarkRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMarkById(Command $command): array
    {
        $uuid = new UUIDType($command->id);
        return $this->convertMarkToArray($this->repository->get($uuid));
    }

    public function countAll(): int
    {
        return $this->repository->countAll();
    }

    public function countAllForFind(CommandFind $command): int
    {
        $name = $command->name ?? null;

        return $this->repository->countAllForFind($name);
    }


    public function getAll(CommandAll $command): array
    {
        $limit = $command->limit;
        $offset = $command->offset;

        $result = [];

        /** @var Mark $mark */
        foreach ($this->repository->getAll($limit, $offset) as $mark) {
            $result[] = self::convertMarkToArray($mark);
        }

        return $result;
    }

    public function find(CommandFind $command): array
    {
        $name = $command->name ?? null;

        $limit = $command->limit;
        $offset = $command->offset;

        $result = [];

        /** @var Mark $mark */
        foreach ($this->repository->find($name, $limit, $offset) as $mark) {
            $result[] = self::convertMarkToArray($mark);
        }

        return $result;
    }

    public function convertMarkToArray(Mark $mark): array
    {
        return [
            'id' => $mark->getId()->getValue(),
            'name' => $mark->getName(),
            'description' => $mark->getDescription(),
            'coordinates' => json_decode($mark->getCoordinates(), true),
            'options' => json_decode($mark->getOptions(), true),
            'content_id' => $mark->getContent()->getId()->getValue(),
            'created_at' => $mark->getCreatedAt()->format(FormatHelper::FRONTEND_DATE_FORMAT),
            'updated_at' => $mark->getUpdatedAt()->format(FormatHelper::FRONTEND_DATE_FORMAT)
        ];
    }
}
