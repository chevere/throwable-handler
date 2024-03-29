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

namespace Chevere\Tests\Documents;

use Chevere\ThrowableHandler\Documents\ConsoleDocument;
use Chevere\ThrowableHandler\Documents\PlainDocument;
use Chevere\ThrowableHandler\Formats\ConsoleFormat;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use Colors\Color;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;

final class ConsoleDocumentTest extends TestCase
{
    public function testConstruct(): void
    {
        $handler = new ThrowableHandler(new ThrowableRead(
            new LogicException(
                'Ups',
                1000,
                new Exception(
                    'Previous',
                    100,
                    new Exception('Pre-previous', 10)
                )
            )
        ));
        $document = new ConsoleDocument($handler);
        $this->assertSame(
            (new Color())->isSupported()
                ? '[31m[1m%title%[0m[0m in [34m[4m%fileLine%[0m[0m'
                : '%title% in %fileLine%',
            $document->getSectionTitle()
        );
        $this->assertInstanceOf(
            ConsoleFormat::class,
            $document->getFormat()
        );
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new PlainDocument($handler);
        $this->assertTrue(
            strlen($sectionTitle) > $plainDocument->getSectionTitle()
        );
        $document->__toString();
    }
}
