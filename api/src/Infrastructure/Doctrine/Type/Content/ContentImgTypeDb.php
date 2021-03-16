<?php

namespace App\Infrastructure\Doctrine\Type\Content;

use App\Model\Content\Type\ContentImgType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ContentImgTypeDb extends StringType
{

    public const NAME = 'content_img_type';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof ContentImgType ? $value->getValue() : (string)$value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ContentImgType|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ContentImgType
    {
        return !empty($value) ? new ContentImgType((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
