<?php

namespace App\Model\Content\Type;

use Webmozart\Assert\Assert;

class ContentJsonType
{
    private array $value;

    public function __construct(array $value)
    {
        Assert::notEmpty($value, 'The content JSON cannot be empty.');
        Assert::isArray($value);
        $this->value = $value;
    }

    public function isEqualTo(self $another): bool
    {
        return empty(array_intersect($this->getValue(), $another->getValue()));
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return json_encode($this->value);
    }
}
