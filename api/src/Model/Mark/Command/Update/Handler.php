<?php

namespace App\Model\Mark\Command\Update;

use App\Infrastructure\Doctrine\Flusher;
use App\Model\Mark\Entity\MarkRepository;
use App\Model\Type\UUIDType;
use DateTimeImmutable;
use DomainException;

class Handler
{
    private Flusher $flusher;
    private MarkRepository $markRepository;

    public function __construct(
        Flusher $flusher,
        MarkRepository $markRepository
    ) {
        $this->flusher = $flusher;
        $this->markRepository = $markRepository;
    }

    public function handle(Command $command): void
    {
        $id = new UUIDType($command->id);
        $name = $command->name ? $command->name : null;
        $description = $command->description ? $command->description : null;
        $coordinates = $command->coordinates ? json_encode($command->coordinates) : null;
        $options = $command->options ? json_encode($command->options) : null;

        if (!$this->markRepository->hasById($id)) {
            throw new DomainException('Mark with this id not found.');
        }

        $mark = $this->markRepository->get($id);

        if ($name) {
            if ($this->markRepository->hasByName($name)) {
                throw new DomainException('Mark with this name already exists.');
            }

            $mark->changeName($name);
        }

        if ($coordinates) {
            if ($this->markRepository->hasByCoordinates($coordinates)) {
                throw new DomainException('Mark with coordinates already exists.');
            }

            $mark->changeCoordinates($coordinates);
        }

        if ($options) {
            $mark->changeOptions($options);
        }

        if ($description) {
            $mark->changeDescription($description);
        }

        $mark->applyUpdatedAt(new DateTimeImmutable());

        $this->flusher->flush();
    }
}
