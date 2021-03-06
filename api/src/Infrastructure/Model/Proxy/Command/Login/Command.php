<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Proxy\Command\Login;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, allowEmptyString=true)
     */
    public string $login = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6, allowEmptyString=true)
     */
    public string $password = '';
}
