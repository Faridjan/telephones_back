<?php

namespace App\Model\Content\Type;

use Webmozart\Assert\Assert;

class ContentImgType
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'The content IMG cannot be empty.');
        Assert::minLength($value, 2, 'The content img value should have 3 characters or more.');
        $this->value = $value;
    }

    public function isEqualTo(self $another): bool
    {
        return mb_strtolower($this->getValue()) === mb_strtolower($another->getValue());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
