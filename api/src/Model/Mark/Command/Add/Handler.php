<?php


namespace App\Model\Mark\Command\Add;


use App\Infrastructure\Doctrine\Flusher;

class Handler
{
    private Flusher $flusher;
    private ContentRepository $contentRepository;
    private MarkRepository $markRepository;

    public function __construct(
        Flusher $flusher,
        ContentRepository $contentRepository,
        MarkRepository $markRepository
    ) {
        $this->flusher = $flusher;
        $this->contentRepository = $contentRepository;
        $this->markRepository = $markRepository;
    }

    public function handle(): void
    {
    }
}