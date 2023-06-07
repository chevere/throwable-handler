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

use Chevere\ThrowableHandler\Documents\PlainDocument;
use Chevere\ThrowableHandler\Formats\PlainFormat;
use Chevere\ThrowableHandler\Interfaces\DocumentInterface;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use LogicException;
use PHPUnit\Framework\TestCase;

final class PlainDocumentTest extends TestCase
{
    public function testConstruct(): void
    {
        $document = new PlainDocument(
            new ThrowableHandler(new ThrowableRead(
                new LogicException(
                    'Ups',
                    1000,
                )
            ))
        );
        $verbosity = 0;
        $this->assertInstanceOf(PlainFormat::class, $document->getFormat());
        $this->assertSame($verbosity, $document->verbosity());
        $verbosity = 16;
        $document = $document->withVerbosity($verbosity);
        $this->assertSame($verbosity, $document->verbosity());
        $getTemplate = $document->getTemplate();
        $this->assertIsArray($getTemplate);
        $this->assertSame(DocumentInterface::SECTIONS, array_keys($getTemplate));
        $document->__toString();
    }
}
