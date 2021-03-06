<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Proxy\Command\Logout;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public string $accessToken = '';
}
