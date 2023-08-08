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

use Chevere\Message\Interfaces\MessageInterface;
use Throwable;
use TypeError;

/**
 * Describes the component in charge of reading a throwable.
 */
interface ThrowableReadInterface
{
    public const DEFAULT_ERROR_TYPE = E_ERROR;

    /**
     * @var string[] Readable PHP error mapping
     */
    public const ERROR_TYPES = [
        E_ERROR => 'Fatal error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parse error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core error',
        E_CORE_WARNING => 'Core warning',
        E_COMPILE_ERROR => 'Compile error',
        E_COMPILE_WARNING => 'Compile warning',
        E_USER_ERROR => 'Fatal error',
        E_USER_WARNING => 'Warning',
        E_USER_NOTICE => 'Notice',
        E_STRICT => 'Strict standards',
        E_RECOVERABLE_ERROR => 'Recoverable error',
        E_DEPRECATED => 'Deprecated',
        E_USER_DEPRECATED => 'Deprecated',
    ];

    /**
     * @var string[] PHP error code LogLevel table. Stripped from Psr\Log
     */
    public const ERROR_LEVELS = [
        E_ERROR => 'critical',
        E_WARNING => 'warning',
        E_PARSE => 'alert',
        E_NOTICE => 'notice',
        E_CORE_ERROR => 'critical',
        E_CORE_WARNING => 'warning',
        E_COMPILE_ERROR => 'alert',
        E_COMPILE_WARNING => 'warning',
        E_USER_ERROR => 'error',
        E_USER_WARNING => 'warning',
        E_USER_NOTICE => 'notice',
        E_STRICT => 'notice',
        E_RECOVERABLE_ERROR => 'error',
        E_DEPRECATED => 'notice',
        E_USER_DEPRECATED => 'notice',
    ];

    public function throwable(): Throwable;

    /**
     * Provides access to the throwable class name.
     */
    public function className(): string;

    /**
     * Provides access to the throwable code.
     */
    public function code(): string;

    /**
     * Provides access to the throwable severity.
     */
    public function severity(): int;

    /**
     * Provides access to the throwable logger level.
     */
    public function loggerLevel(): string;

    /**
     * Provides access to the throwable type.
     */
    public function type(): string;

    /**
     * Provides access to the throwable message.
     */
    public function message(): MessageInterface;

    /**
     * Provides access to the throwable file.
     */
    public function file(): string;

    /**
     * Provides access to the throwable line.
     */
    public function line(): int;

    /**
     * Provides access to the throwable trace.
     *
     * @return array<array<string, mixed>>
     */
    public function trace(): array;

    /**
     * Indicates whether the instance has a previous throwable.
     */
    public function hasPrevious(): bool;

    /**
     * Provides access to previous throwable (if any).
     *
     * @throws TypeError If no previous
     */
    public function previous(): Throwable;
}
