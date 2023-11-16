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

namespace Chevere\Tests;

use Chevere\ThrowableHandler\ThrowableHandler;
use ErrorException;
use PHPUnit\Framework\TestCase;
use function Chevere\ThrowableHandler\errorAsException;
use function Chevere\ThrowableHandler\shutdownErrorAsException;

final class FunctionsTest extends TestCase
{
    public function testConstants(): void
    {
        $constants = [
            ThrowableHandler::ERROR_AS_EXCEPTION,
            ThrowableHandler::SHUTDOWN_ERROR_AS_EXCEPTION,
            ThrowableHandler::PLAIN,
            ThrowableHandler::CONSOLE,
            ThrowableHandler::HTML,
        ];
        foreach ($constants as $constant) {
            $this->assertTrue(function_exists($constant));
        }
    }

    public function testErrorAsException(): void
    {
        $this->expectException(ErrorException::class);
        errorAsException(0, 'error', __FILE__, __LINE__);
    }

    public function testShutdownErrorAsException(): void
    {
        $this->expectNotToPerformAssertions();
        shutdownErrorAsException();
    }
}
