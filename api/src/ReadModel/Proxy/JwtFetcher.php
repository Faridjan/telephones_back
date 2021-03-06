<?php

declare(strict_types=1);

namespace App\ReadModel\Proxy;

use App\Infrastructure\Model\Proxy\Command\Login\Command as CommandLogin;
use App\Infrastructure\Model\Proxy\Command\Refresh\Command as CommandRefresh;
use App\Infrastructure\Model\Proxy\Command\Check\Command as CommandCheck;
use Proxy\OAuth\Interfaces\ConfigStorageInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;
use Proxy\OAuth\Model\Access\Type\PasswordType;
use Proxy\OAuth\Model\Access\Type\UsernameType;
use Proxy\OAuth\Proxy;

class JwtFetcher
{
    private ConverterInterface $converter;
    private ConfigStorageInterface $configStorage;
    private HttpClientInterface $client;

    /**
     * JwtFetcher constructor.
     * @param ConverterInterface $converter
     * @param ConfigStorageInterface $configStorage
     * @param HttpClientInterface $client
     */
    public function __construct(
        ConverterInterface $converter,
        ConfigStorageInterface $configStorage,
        HttpClientInterface $client
    ) {
        $this->converter = $converter;
        $this->configStorage = $configStorage;
        $this->client = $client;
    }

    public function getJwtByLogin(CommandLogin $command): string
    {
        $proxy = new Proxy($this->converter, $this->configStorage, $this->client);

        return $encryptedJwt = $proxy->login(
            new UsernameType($command->login),
            new PasswordType($command->password)
        );
    }

    public function getJwtByRefreshToken(CommandRefresh $command): string
    {
        $proxy = new Proxy($this->converter, $this->configStorage, $this->client);

        return $proxy->refresh(json_encode(['refresh_token' => $command->refreshToken]));
    }

    public function getJwtByCheck(CommandCheck $command): string
    {
        $proxy = new Proxy($this->converter, $this->configStorage, $this->client);

        return $proxy->check(json_encode(['access_token' => $command->accessToken]));
    }
}
