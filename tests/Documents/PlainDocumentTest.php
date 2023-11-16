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
    public function testVerbosity(): void
    {
        $code = 1000;
        $message = 'Ups';
        $id = 'TEST_ID';
        $exception = new LogicException($message, $code);
        $fileLine = __FILE__ . ':' . (__LINE__ - 1);
        $read = new ThrowableRead($exception);
        $handler = new ThrowableHandler($read);
        $handler = $handler->withId($id);
        $document = new PlainDocument($handler);
        $verbosity = 0;
        $this->assertInstanceOf(PlainFormat::class, $document->getFormat());
        $this->assertSame($verbosity, $document->verbosity());
        $verbosity = 16;
        $document = $document->withVerbosity($verbosity);
        $this->assertSame($verbosity, $document->verbosity());
        $getTemplate = $document->getTemplate();
        $this->assertSame(DocumentInterface::SECTIONS, array_keys($getTemplate));
        $this->assertSame(
            <<<PLAIN
            LogicException thrown in {$fileLine}

            # Message [Code #{$code}]
            {$message}

            # Incident ID:{$id}
            PLAIN,
            $document->__toString()
        );
    }
}
