<?php

declare(strict_types=1);

namespace App\Helper\Command;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

trait PaginationTrait
{
    /**
     * @var int|string|null
     */
    public $page;
    /**
     * @var int|string|null
     */
    public $limit;
    /**
     * @var int|string|null
     */
    public $offset;

    public function isPage(): bool
    {
        $this->page = is_numeric($this->page) ? (int)$this->page : $this->page;

        return is_int($this->page) ? $this->page > 0 : false;
    }

    public function isLimit(): bool
    {
        $this->limit = is_numeric($this->limit) ? (int)$this->limit : $this->limit;

        return is_null($this->limit) || is_int($this->limit);
    }

    public function isOffset(): bool
    {
        $this->offset = is_numeric($this->offset) ? (int)$this->offset : $this->offset;

        return is_null($this->offset) || is_int($this->offset);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint(
            'page',
            new Assert\IsTrue(
                [
                    'message' => 'This value should be of type int.',
                ]
            )
        );

        $metadata->addPropertyConstraint('page', new Assert\Positive());

        $metadata->addGetterConstraint(
            'limit',
            new Assert\IsTrue(
                [
                    'message' => 'This value should be of type int|null.',
                ]
            )
        );

        $metadata->addGetterConstraint(
            'offset',
            new Assert\IsTrue(
                [
                    'message' => 'This value should be of type int|null.',
                ]
            )
        );
    }
}
