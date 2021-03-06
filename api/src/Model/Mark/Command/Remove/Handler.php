<?php


namespace App\Model\Mark\Command\Remove;


use App\Infrastructure\Doctrine\Flusher;
use App\Model\Mark\Entity\MarkRepository;
use App\Model\Type\UUIDType;
use DomainException;

class Handler
{
    private Flusher $flusher;
    private MarkRepository $repository;

    /**
     * Handler constructor.
     * @param Flusher $flusher
     * @param MarkRepository $repository
     */
    public function __construct(Flusher $flusher, MarkRepository $repository)
    {
        $this->flusher = $flusher;
        $this->repository = $repository;
    }

    public function handle(Command $command): void
    {
        $uuidType = new UUIDType($command->id);

        if (!$this->repository->hasById($uuidType)) {
            throw new DomainException('Mark with this id not found.');
        }
        $mark = $this->repository->get($uuidType);

        $this->repository->remove($mark);

        $this->flusher->flush();
    }
}
