<?php


namespace App\Model\Mark\Command\Update;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id = '';

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=2, allowEmptyString=true)
     */
    public ?string $name;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=2, allowEmptyString=true)
     */
    public ?string $description;

    /**
     * @Assert\Type("array")
     * @Assert\Count(min=1)
     */
    public ?array $coordinates;

    /**
     * @Assert\Type("array")
     * @Assert\Count(min=0)
     */
    public ?array $options;

    private bool $update;

    public function isUpdate(): bool
    {
        if (
            !$this->name
            && !$this->description
            && !$this->coordinates
            && !$this->options
        ) {
            return false;
        }

        return true;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint(
            'update',
            new Assert\IsTrue(
                [
                    'message' => 'Nothing to update.',
                ]
            )
        );
    }
}
