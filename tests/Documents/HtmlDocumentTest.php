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

use Chevere\ThrowableHandler\Documents\HtmlDocument;
use Chevere\ThrowableHandler\Documents\PlainDocument;
use Chevere\ThrowableHandler\Formats\HtmlFormat;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\ThrowableHandler\ThrowableHandler;
use Chevere\ThrowableHandler\ThrowableRead;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;

final class HtmlDocumentTest extends TestCase
{
    private ThrowableHandlerInterface $exceptionHandler;

    protected function setUp(): void
    {
        $this->exceptionHandler = new ThrowableHandler(new ThrowableRead(
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
    }

    public function testHandlerDebugOn(): void
    {
        $this->exceptionHandler = $this->exceptionHandler->withIsDebug(true);
        $document = new HtmlDocument($this->exceptionHandler);
        $this->assertInstanceOf(HtmlFormat::class, $document->getFormat());
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new PlainDocument($this->exceptionHandler);
        $this->assertTrue(strlen($sectionTitle) > $plainDocument->getSectionTitle());
        $string = $document->__toString();
        $this->assertStringContainsString('<meta charset="utf-8">', $string);
        $this->assertStringContainsString('<main class="main--stack">', $string);
    }

    public function testHandlerDebugOff(): void
    {
        $this->exceptionHandler = $this->exceptionHandler->withIsDebug(false);
        $document = new HtmlDocument($this->exceptionHandler);
        $this->assertInstanceOf(HtmlFormat::class, $document->getFormat());
        $sectionTitle = $document->getSectionTitle();
        $plainDocument = new PlainDocument($this->exceptionHandler);
        $this->assertTrue(strlen($sectionTitle) > $plainDocument->getSectionTitle());
        $string = $document->__toString();
        $this->assertStringContainsString('<meta charset="utf-8">', $string);
        $this->assertStringContainsString('Something went wrong', $string);
        $this->assertStringContainsString('Please try again later.', $string);
        $this->assertStringContainsString('<main class="user-select-none"><div>', $string);
        $this->assertStringContainsString('</span> • <span class="user-select-all">', $string);
    }
}
