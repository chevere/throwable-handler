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

use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use DateTimeInterface;
use LogicException;
use PHPUnit\Framework\TestCase;

final class ThrowableHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $handler = $this->getExceptionHandler();
        $this->assertInstanceOf(DateTimeInterface::class, $handler->dateTimeUtc());
        $this->assertInstanceOf(ThrowableRead::class, $handler->throwableRead());
        $this->assertIsString($handler->id());
        $this->assertTrue($handler->isDebug());
        $this->assertSame([], $handler->extra());
    }

    public function testWithDebug(): void
    {
        $handler = $this->getExceptionHandler();
        $with = $handler->withIsDebug(true);
        $this->assertNotSame($handler, $with);
        $this->assertTrue(
            $with->isDebug()
        );
    }

    public function testWithId(): void
    {
        $handler = $this->getExceptionHandler();
        $id = 'the-id';
        $with = $handler->withId($id);
        $this->assertNotSame($handler, $with);
        $this->assertSame(
            $id,
            $with->id()
        );
    }

    public function testWithPutExtra(): void
    {
        $handler = $this->getExceptionHandler();
        $title = 'My title';
        $value = 'My value';
        $with = $handler
            ->withPutExtra($title, $value)
            ->withPutExtra($title, $value);
        $this->assertNotSame($handler, $with);
        $this->assertSame(
            [
                $title => $value,
            ],
            $with->extra()
        );
    }

    private function getExceptionHandler(): ThrowableHandlerInterface
    {
        return
            new ThrowableHandler(
                new ThrowableRead(
                    new LogicException('Ups', 100)
                )
            );
    }
}
