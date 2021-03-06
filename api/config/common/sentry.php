<?php

declare(strict_types=1);

use App\Infrastructure\Sentry\SentryClient;
use App\Http\Middleware\Catchers\Sentry\SentryExceptionMiddleware;
use Psr\Container\ContainerInterface;

return [
    SentryExceptionMiddleware::class => static function (ContainerInterface $container): SentryExceptionMiddleware {
        return new SentryExceptionMiddleware($container->get(SentryClient::class));
    },

    SentryClient::class => static function (ContainerInterface $container): SentryClient {
        return new SentryClient(
            $container->get('config')['sentry']['init'],
            $container->get('config')['sentry']['production']
        );
    },

    'config' => [
        'sentry' => [
            'init' => [
                'dsn' => getenv('SENTRY_DSN'),
                'max_breadcrumbs' => 50,
            ],
            'production' => ($mode = getenv('APP_ENV')) ? ($mode == 'prod') : false
        ]
    ]
];
