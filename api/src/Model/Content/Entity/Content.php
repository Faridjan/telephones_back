<?php

namespace App\Model\Content\Entity;

use App\Model\Content\Type\ContentFileType;
use App\Model\Content\Type\ContentHtmlType;
use App\Model\Content\Type\ContentImgType;
use App\Model\Mark\Entity\Mark;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Type\UUIDType;
use DomainException;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Content
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid_type")
     */
    private UUIDType $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Mark\Entity\Mark", mappedBy="content")
     */
    private ?Mark $mark;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $contentJson;

    /**
     * @ORM\Column(type="content_html_type", nullable=true)
     */
    private ?ContentHtmlType $contentHtml;

    /**
     * @ORM\Column(type="content_img_type", nullable=true)
     */
    private ?ContentImgType $contentImg;

    /**
     * @ORM\Column(type="content_file_type", nullable=true)
     */
    private ?ContentFileType $contentFile;

    public function __construct(
        UUIDType $id,
        ?Mark $mark = null,
        ?array $contentJson = null,
        ?ContentHtmlType $contentHtml = null,
        ?ContentImgType $contentImg = null,
        ?ContentFileType $contentFile = null
    ) {
        $this->id = $id;
        $this->mark = $mark;
        $this->contentJson = $contentJson;
        $this->contentHtml = $contentHtml;
        $this->contentImg = $contentImg;
        $this->contentFile = $contentFile;
    }

    /**
     * @return Mark|null
     */
    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    /**
     * @return UUIDType
     */
    public function getId(): UUIDType
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getContentJson(): ?array
    {
        return $this->contentJson;
    }

    /**
     * @param array|null $contentJson
     */
    public function changeContentJson(?array $contentJson): void
    {
        $this->contentJson = $contentJson;
    }

    /**
     * @return ContentHtmlType|null
     */
    public function getContentHtml(): ?ContentHtmlType
    {
        return $this->contentHtml;
    }

    /**
     * @param ContentHtmlType|null $contentHtml
     */
    public function changeContentHtml(?ContentHtmlType $contentHtml): void
    {
        if ($this->contentHtml->isEqualTo($contentHtml)) {
            throw new DomainException('Content HTML is already same.');
        }
        $this->contentHtml = $contentHtml;
    }

    /**
     * @return ContentImgType|null
     */
    public function getContentImg(): ?ContentImgType
    {
        return $this->contentImg;
    }

    /**
     * @param ContentImgType|null $contentImg
     */
    public function changeContentImg(?ContentImgType $contentImg): void
    {
        if ($this->contentImg->isEqualTo($contentImg)) {
            throw new DomainException('Content IMG is already same.');
        }
        $this->contentImg = $contentImg;
    }

    /**
     * @return ContentFileType|null
     */
    public function getContentFile(): ?ContentFileType
    {
        return $this->contentFile;
    }

    /**
     * @param ContentFileType|null $contentFile
     */
    public function changeContentFile(?ContentFileType $contentFile): void
    {
        if ($this->contentFile->isEqualTo($contentFile)) {
            throw new DomainException('File is already same.');
        }
        $this->contentFile = $contentFile;
    }

}
