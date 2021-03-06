<?php

namespace App\Model\Mark\Entity;

use App\Model\Content\Entity\Content;
use App\Model\Type\UUIDType;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Mark
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid_type")
     */
    private UUIDType $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Content\Entity\Content", inversedBy="mark")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     */
    private ?Content $content;

    /**
     * @ORM\Column(type="json")
     */
    private array $coordinates;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $options;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;

    public function __construct(
        UUIDType $id,
        string $name,
        DateTimeImmutable $createdAt,
        array $coordinates,
        ?Content $content = null,
        ?string $description = null,
        ?array $options = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->content = $content;
        $this->coordinates = $coordinates;
        $this->options = $options;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    /**
     * @return UUIDType
     */
    public function getId(): UUIDType
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Content|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content|string $content
     */
    public function changeContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @param array $coordinates
     */
    public function changeCoordinates(array $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array|null $options
     */
    public function setOptions(?array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function applyUpdatedAt(DateTimeImmutable $date): void
    {
        $this->updatedAt = $date;
    }
}
