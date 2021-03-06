<?php


namespace App\Model\Mark\Command\Remove;


use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id = '';
}
