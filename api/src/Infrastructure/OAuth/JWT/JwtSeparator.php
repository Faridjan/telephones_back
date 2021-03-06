<?php

declare(strict_types=1);

namespace App\Infrastructure\OAuth\JWT;

class JwtSeparator
{
    public static function getPayload(string $jwt): array
    {
        $tokenParts = explode(".", $jwt);
        $tokenPayload = base64_decode($tokenParts[1]);

        return $jwtPayload = json_decode($tokenPayload, true);
    }

    public static function getHeader(string $jwt): array
    {
        $tokenParts = explode(".", $jwt);
        $tokenHeader = base64_decode($tokenParts[0]);

        return $jwtHeader = json_decode($tokenHeader);
    }
}
