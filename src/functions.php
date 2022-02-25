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

use Chevere\Message\Message;
use Chevere\Throwable\Exceptions\ErrorException;
use Chevere\ThrowableHandler\Documents\ThrowableHandlerConsoleDocument;
use Chevere\ThrowableHandler\Documents\ThrowableHandlerHtmlDocument;
use Chevere\ThrowableHandler\Documents\ThrowableHandlerPlainDocument;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerDocumentInterface;
use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerInterface;
use function Chevere\Writer\streamFor;
use Chevere\Writer\StreamWriter;
use Chevere\Writer\WritersInstance;
use LogicException;
use Throwable;

function handleAsPlain(Throwable $throwable): void
{
    handleExceptionDocument(
        plainDocument($throwable)
    );
}

function plainDocument(Throwable $throwable): ThrowableHandlerPlainDocument
{
    return new ThrowableHandlerPlainDocument(
        throwableHandler($throwable)
    );
}

function handleAsConsole(Throwable $throwable): void
{
    handleExceptionDocument(
        consoleDocument($throwable)
    );
}

function consoleDocument(Throwable $throwable): ThrowableHandlerConsoleDocument
{
    return new ThrowableHandlerConsoleDocument(
        throwableHandler($throwable)
    );
}

function handleasHtml(Throwable $throwable): void
{
    if (!headers_sent()) {
        http_response_code(500);
    }
    handleExceptionDocument(
        htmlDocument($throwable)
    );
}

function htmlDocument(Throwable $throwable): ThrowableHandlerHtmlDocument
{
    return new ThrowableHandlerHtmlDocument(
        throwableHandler($throwable)
    );
}

function throwableHandler(Throwable $throwable): ThrowableHandlerInterface
{
    return new ThrowableHandler(new ThrowableRead($throwable));
}

function handleExceptionDocument(ThrowableHandlerDocumentInterface $document): void
{
    try {
        $writer = WritersInstance::get()->error();
    } catch (LogicException $e) {
        $writer = new StreamWriter(streamFor('php://stderr', 'w'));
    }
    $writer->write($document->__toString() . "\n");

    die(255);
}

function errorsAsExceptions(int $severity, string $message, string $file, int $line): void
{
    throw new ErrorException(new Message($message), 0, $severity, $file, $line);
}

function shutdownErrorsAsExceptions(): void
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
            message: new Message($error["message"]),
            code: 0,
            severity: $error["type"],
            filename: $error["file"],
            lineno: $error["line"]
        )
    );
}
