<?php


namespace App\Model\Mark\Command\Find;


use App\Helper\Command\PaginationTrait;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    use PaginationTrait;

    /**
     * @Assert\Type("string")
     */
    public ?string $name;
}
