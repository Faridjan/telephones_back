<?php

namespace App\Model\Mark\Command\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2)
     */
    public string $name = '';

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=3, allowEmptyString=true)
     */
    public ?string $description = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Type("array")
     * @Assert\Count(min=1)
     */
    public array $coordinates = [];

    /**
     * @Assert\Type("array")
     * @Assert\Count(min=0)
     */
    public ?array $options = null;

    /**
     * @Assert\Type("array")
     * @Assert\Count(min=0)
     */
    public ?array $contentJson;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, allowEmptyString=true)
     */
    public ?string $contentHtml;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, allowEmptyString=true)
     */
    public ?string $contentImg;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, allowEmptyString=true)
     */
    public ?string $contentFile;
}
