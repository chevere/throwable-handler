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

namespace Chevere\ThrowableHandler\Interfaces;

use DateTimeInterface;

/**
 * Describes the component in charge of handling throwables.
 */
interface ThrowableHandlerInterface
{
    public function __construct(ThrowableReadInterface $throwableRead);

    public function withIsDebug(bool $isDebug): self;

    public function withId(string $id): self;

    public function isDebug(): bool;

    public function dateTimeUtc(): DateTimeInterface;

    public function throwableRead(): ThrowableReadInterface;

    public function id(): string;

    /**
     * Return an instance with the specified put extra data.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified put extra data.
     */
    public function withPutExtra(string $title, string $value): self;

    /**
     * Extra throwable data to display.
     *
     * @return array<string, string>
     */
    public function extra(): array;
}
