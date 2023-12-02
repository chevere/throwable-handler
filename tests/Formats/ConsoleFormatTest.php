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

namespace Chevere\Tests\Formats;

use Chevere\ThrowableHandler\Formats\ConsoleFormat;
use Chevere\ThrowableHandler\Formats\PlainFormat;
use PHPUnit\Framework\TestCase;

final class ConsoleFormatTest extends TestCase
{
    public function testConstruct(): void
    {
        $plainFormatter = new PlainFormat();
        $consoleFormatter = new ConsoleFormat();
        $array = [
            'getItemTemplate' => [],
            'getHr' => [],
            'getLineBreak' => [],
            'getWrapLink' => ['value'],
            'getWrapSectionTitle' => ['value'],
            'getWrapTitle' => ['value'],
        ];
        foreach ($array as $methodName => $args) {
            $plain = $plainFormatter->{$methodName}(...$args);
            $console = $consoleFormatter->{$methodName}(...$args);
            $this->assertSame(
                $plain,
                preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $console) ?? ''
            );
        }
    }
}
