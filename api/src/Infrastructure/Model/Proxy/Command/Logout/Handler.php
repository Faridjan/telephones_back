<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Proxy\Command\Logout;

use Proxy\OAuth\Interfaces\ConfigStorageInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;
use Proxy\OAuth\Proxy;

class Handler
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

    public function handle(Command $command): void
    {
        $proxy = new Proxy($this->converter, $this->configStorage, $this->client);

        $proxy->logout(json_encode(['access_token' => $command->accessToken]));
    }
}
