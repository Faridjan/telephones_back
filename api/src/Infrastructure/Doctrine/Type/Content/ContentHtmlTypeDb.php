<?php


namespace App\Infrastructure\Doctrine\Type\Content;


use App\Model\Content\Type\ContentHtmlType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ContentHtmlTypeDb extends StringType
{

    public const NAME = 'content_html_type';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        return $value instanceof ContentHtmlType ? base64_encode($value->getValue()) : (string)$value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return ContentHtmlType|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ContentHtmlType
    {
        return !empty($value) ? new ContentHtmlType(base64_decode($value)) : null;
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