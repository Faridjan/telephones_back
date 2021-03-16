<?php

namespace App\Infrastructure\Doctrine\Type\Content;

use App\Model\Content\Type\ContentFileType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ContentFileTypeDb extends StringType
{

    public const NAME = 'content_file_type';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof ContentFileType ? $value->getValue() : (string)$value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ContentFileType|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ContentFileType
    {
        return !empty($value) ? new ContentFileType((string)$value) : null;
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
