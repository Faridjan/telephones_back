<?php


namespace App\ReadModel\Content;


use App\Helper\FormatHelper;
use App\Model\Content\Command\Content\Command;
use App\Model\Content\Entity\Content;
use App\Model\Content\Entity\ContentRepository;
use App\Model\Type\UUIDType;

class ContentFetcher
{
    private ContentRepository $repository;

    public function __construct(ContentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getContentById(Command $command): array
    {
        $uuid = new UUIDType($command->id);
        return $this->convertContentToArray($this->repository->get($uuid));
    }

    public function countAll(): int
    {
        return $this->repository->countAll();
    }
//
//    public function countAllForFind(CommandFind $command): int
//    {
//        $name = $command->name ?? null;
//
//        return $this->repository->countAllForFind($name);
//    }
//
//
//    public function getAll(CommandAll $command): array
//    {
//        $limit = $command->limit;
//        $offset = $command->offset;
//
//        $result = [];
//
//        /** @var Content $content */
//        foreach ($this->repository->getAll($limit, $offset) as $content) {
//            $result[] = self::convertContentToArray($content);
//        }
//
//        return $result;
//    }
//
//    public function find(CommandFind $command): array
//    {
//        $name = $command->name ?? null;
//
//        $limit = $command->limit;
//        $offset = $command->offset;
//
//        $result = [];
//
//        /** @var Content $content */
//        foreach ($this->repository->find($name, $limit, $offset) as $content) {
//            $result[] = self::convertContentToArray($content);
//        }
//
//        return $result;
//    }


    public function convertContentToArray(Content $content): array
    {
        return [
            'id' => $content->getId()->getValue(),
            'content_json' => $content->hasContentJson() ? json_decode($content->getContentJson(), true) : null,
            'content_html' => $content->hasContentHtml() ? $content->getContentHtml()->getValue() : null,
            'content_img' => $content->hasContentImg() ? $content->getContentImg()->getValue() : null,
            'content_file' => $content->hasContentFile() ? $content->getContentFile()->getValue() : null,
            'created_at' => $content->getCreatedAt()->format(FormatHelper::FRONTEND_DATE_FORMAT),
            'updated_at' => $content->getUpdatedAt()->format(FormatHelper::FRONTEND_DATE_FORMAT)
        ];
    }
}