<?php

/*
 * This file is part of Chevere.
 *
 * (c) Rodolfo Berrios <rodolfo@chevere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Chevere\ThrowableHandler;

use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\ThrowableHandler\Interfaces\ThrowableReadInterface;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class ThrowableHandler implements ThrowableHandlerInterface
{
    public const ERROR_AS_EXCEPTION = __NAMESPACE__ . '\errorAsException';

    public const SHUTDOWN_ERROR_AS_EXCEPTION = __NAMESPACE__ . '\shutdownErrorAsException';

    public const PLAIN = __NAMESPACE__ . '\handleAsPlain';

    public const CONSOLE = __NAMESPACE__ . '\handleAsConsole';

    public const HTML = __NAMESPACE__ . '\handleAsHtml';

    private DateTimeInterface $dateTimeUtc;

    private string $id;

    private bool $isDebug = true;

    public function __construct(
        private ThrowableReadInterface $throwableRead
    ) {
        $this->dateTimeUtc = new DateTimeImmutable(
            'now',
            new DateTimeZone('UTC')
        );
        $this->id = uniqid('');
    }

    public function withIsDebug(bool $isDebug): ThrowableHandlerInterface
    {
        $new = clone $this;
        $new->isDebug = $isDebug;

        return $new;
    }

    public function isDebug(): bool
    {
        return $this->isDebug;
    }

    public function dateTimeUtc(): DateTimeInterface
    {
        return $this->dateTimeUtc;
    }

    public function throwableRead(): ThrowableReadInterface
    {
        return $this->throwableRead;
    }

    public function id(): string
    {
        return $this->id;
    }
}
