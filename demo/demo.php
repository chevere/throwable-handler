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

use function Chevere\Filesystem\fileForPath;
use Chevere\ThrowableHandler\Documents\ConsoleDocument;
use Chevere\ThrowableHandler\Documents\HtmlDocument;
use Chevere\ThrowableHandler\Documents\PlainDocument;
use function Chevere\ThrowableHandler\throwableHandler;

require_once __DIR__ . '/../vendor/autoload.php';

function stripLocal(string $document): string
{
    return str_replace(
        dirname(__DIR__) . '/demo/',
        '/var/www/html/',
        $document
    );
}

try {
    require __DIR__ . '/throws/runtime.php';
} catch (Throwable $e) {
    $handler = throwableHandler($e);
    $console = new ConsoleDocument($handler);
    $plain = new PlainDocument($handler);
    $html = new HtmlDocument(
        $handler->withIsDebug(true)
    );
    $htmlSilent = new HtmlDocument(
        $handler->withIsDebug(false)
    );
    foreach ([
        'console.log' => strval($console),
        'plain.txt' => strval($plain),
        'html.html' => strval($html),
        'html-silent.html' => strval($htmlSilent),
    ] as $filename => $document) {
        $document = stripLocal($document);
        if ($filename === 'console.log') {
            echo $document;
            echo "\n";
        }
        $file = fileForPath(__DIR__ . '/output/' . $filename);
        $file->createIfNotExists();
        $file->put($document);
        $path = $file->path()->__toString();
    }
}
