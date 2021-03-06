<?php

declare(strict_types=1);

namespace App\Infrastructure\Sentry;

use Sentry;
use Throwable;
use Webmozart\Assert\Assert;

class SentryClient
{
    private array $options;
    private bool $productionMode = false;

    public function __construct(array $options, bool $productionMode)
    {
        Assert::true(array_key_exists('dsn', $options), 'Sentry options doesn\'t set dsn.');
        Assert::true(
            array_key_exists('max_breadcrumbs', $options),
            'Sentry options doesn\'t set max_breadcrumbs.'
        );

        if ($productionMode) {
            if (!empty($options['dsn'])) {
                $this->productionMode = $productionMode;
            }
        }

        $this->options = $options;
    }

    public function isProduction(): bool
    {
        return $this->productionMode;
    }

    public function pushException(Throwable $exception): void
    {
        if ($this->options['dsn']) {
            Sentry\init($this->options);
            Sentry\captureException($exception);
        }
    }
}
