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

namespace Chevere\ThrowableHandler;

use function Chevere\Message\message;
use Chevere\Throwable\Exceptions\ErrorException;
use Chevere\ThrowableHandler\Documents\ConsoleDocument;
use Chevere\ThrowableHandler\Documents\HtmlDocument;
use Chevere\ThrowableHandler\Documents\PlainDocument;
use Chevere\ThrowableHandler\Interfaces\DocumentInterface;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use Chevere\Writer\Interfaces\WriterInterface;
use function Chevere\Writer\streamFor;
use Chevere\Writer\StreamWriter;
use Chevere\Writer\WritersInstance;
use Throwable;

// @codeCoverageIgnoreStart

/**
 * Handle throwables as plain documents.
 */
function handleAsPlain(Throwable $throwable): void
{
    writeThrowableDocument(
        plainDocument($throwable)
    );
}

/**
 * Handle throwables as console documents.
 */
function handleAsConsole(Throwable $throwable): void
{
    writeThrowableDocument(
        consoleDocument($throwable)
    );
}

/**
 * Handle throwables as HTML documents.
 */
function handleAsHtml(Throwable $throwable): void
{
    if (!headers_sent()) {
        http_response_code(500);
    }
    writeThrowableDocument(
        htmlDocument($throwable)
    );
}

/**
 * Get a plain document from a throwable.
 */
function plainDocument(Throwable $throwable): PlainDocument
{
    return new PlainDocument(
        throwableHandler($throwable)
    );
}

/**
 * Get a console document from a throwable.
 */
function consoleDocument(Throwable $throwable): ConsoleDocument
{
    return new ConsoleDocument(
        throwableHandler($throwable)
    );
}

/**
 * Get a HTML document from a throwable.
 */
function htmlDocument(Throwable $throwable): HtmlDocument
{
    return new HtmlDocument(
        throwableHandler($throwable)
    );
}

/**
 * Get a throwable handler from a throwable.
 */
function throwableHandler(Throwable $throwable): ThrowableHandlerInterface
{
    return new ThrowableHandler(new ThrowableRead($throwable));
}

/**
 * Write a throwable document.
 */
function writeThrowableDocument(
    DocumentInterface $document,
    ?WriterInterface $writer = null
): void {
    try {
        $writer = $writer ?? WritersInstance::get()->error();
    } catch (Throwable $e) {
        $writer = new StreamWriter(streamFor('php://stderr', 'w'));
    }
    $writer->write($document->__toString() . "\n");

    die(255);
}

/**
 * Handle error as ErrorException.
 */
function errorAsException(int $severity, string $message, string $file, int $line): void
{
    throw new ErrorException(message($message), 0, $severity, $file, $line);
}

/**
 * Handle shutdown error as ErrorException.
 */
function shutdownErrorAsException(): void
{
    $error = error_get_last();
    if ($error === null) {
        return;
    }
    $handler = set_exception_handler(function () {
        // dummy
    });
    restore_exception_handler();
    $handler(
        new ErrorException(
            message: message($error["message"]),
            code: 0,
            severity: $error["type"],
            filename: $error["file"],
            lineno: $error["line"]
        )
    );
}

// @codeCoverageIgnoreEnd
