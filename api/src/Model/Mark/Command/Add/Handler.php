<?php


namespace App\Model\Mark\Command\Add;


use App\Infrastructure\Doctrine\Flusher;
use App\Model\Content\Entity\Content;
use App\Model\Content\Entity\ContentRepository;
use App\Model\Content\Type\ContentFileType;
use App\Model\Content\Type\ContentHtmlType;
use App\Model\Content\Type\ContentImgType;
use App\Model\Mark\Entity\Mark;
use App\Model\Mark\Entity\MarkRepository;
use App\Model\Type\UUIDType;
use DateTimeImmutable;
use DomainException;

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

    public function handle(Command $command): array
    {
        $name = $command->name;
        $description = $command->description ? $command->description : null;
        $coordinates = !empty($command->coordinates) ? json_encode($command->coordinates) : null;
        $options = !empty($command->options) ? json_encode($command->options) : null;

        $contentJson = !empty($command->contentJson) ? json_encode($command->contentJson) : null;
        $contentHtml = $command->contentHtml ? new ContentHtmlType($command->contentHtml) : null;
        $contentFile = $command->contentFile ? new ContentFileType($command->contentFile) : null;
        $contentImg = $command->contentImg ? new ContentImgType($command->contentImg) : null;

        if ($this->markRepository->hasByName($name)) {
            throw new DomainException('Mark with this name already exist.');
        }

        if ($coordinates && $this->markRepository->hasByCoordinates($coordinates)) {
            throw new DomainException('Mark with this coordinates already exist.');
        }

        $content = new Content(
            $contentID = UUIDType::generate(),
            new DateTimeImmutable(),
            $contentJson,
            $contentHtml,
            $contentImg,
            $contentFile
        );

        $this->contentRepository->add($content);

        $mark = new Mark(
            $markId = UUIDType::generate(),
            $name,
            $coordinates,
            new DateTimeImmutable(),
            $description,
            $content,
            $options
        );

        $this->markRepository->add($mark);

        $this->flusher->flush();

        return [
            'mark_id' => $markId->getValue(),
            'content_id' => $contentID->getValue()
        ];
    }
}