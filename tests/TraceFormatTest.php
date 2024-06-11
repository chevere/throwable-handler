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

use Chevere\ThrowableHandler\Formats\PlainFormat;
use Chevere\Trace\Trace;
use Exception;
use PHPUnit\Framework\TestCase;

final class TraceFormatTest extends TestCase
{
    private string $hrLine;

    protected function setUp(): void
    {
        $this->hrLine = str_repeat('-', 60);
    }

    public function testRealStackTrace(): void
    {
        $e = new Exception('Message', 100);
        $document = new Trace($e->getTrace(), new PlainFormat());
        $this->assertIsArray($document->toArray());
        $this->assertIsString($document->__toString());
    }

    public function testNullStackTrace(): void
    {
        $trace = [
            0 => [
                'file' => null,
                'line' => null,
                'function' => null,
                'class' => null,
                'type' => null,
                'args' => [false, null],
            ],
        ];
        $document = new Trace(
            $trace,
            new PlainFormat()
        );
        $this->assertSame([
            0 => "0 \n(bool(false), null)",
        ], $document->toArray());
        $this->assertSame(
            $this->hrLine
            . "\n0 "
            . "\n(bool(false), null)"
            . "\n"
            . $this->hrLine,
            $document->__toString()
        );
    }

    public function testFakeStackTrace(): void
    {
        $file = __FILE__;
        $line = 123;
        $fqn = 'The\\Full\\className';
        $type = '->';
        $method = 'methodName';
        $trace = [
            0 => [
                'file' => $file,
                'line' => $line,
                'function' => $method,
                'class' => $fqn,
                'type' => $type,
                'args' => [],
            ],
            1 => [
                'file' => $file,
                'line' => $line,
                'function' => $method,
                'class' => $fqn,
                'type' => $type,
                'args' => [],
            ],
        ];
        $document = new Trace(
            $trace,
            new PlainFormat()
        );
        $expectEntries = [];
        foreach (array_keys($trace) as $pos) {
            $expect = "{$pos} {$file}:{$line}\n{$fqn}{$type}{$method}()";
            $expectEntries[] = $expect;
            $this->assertSame(
                $expect,
                $document->toArray()[$pos]
            );
        }
        $expectString = $this->hrLine
            . "\n"
            . implode("\n" . $this->hrLine . "\n", $expectEntries)
            . "\n"
            . $this->hrLine;
        $this->assertSame($expectString, $document->__toString());
    }
}
