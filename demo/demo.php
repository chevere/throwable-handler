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

use Chevere\ThrowableHandler\Documents\ConsoleDocument;
use Chevere\ThrowableHandler\Documents\HtmlDocument;
use Chevere\ThrowableHandler\Documents\PlainDocument;
use Chevere\Writer\StreamWriter;
use function Chevere\ThrowableHandler\throwableHandler;
use function Chevere\Writer\streamTemp;

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
    $writer = new StreamWriter(streamTemp());
    $payload = [
        'name' => 'Rodolfo',
        'role' => 'admin',
    ];
    $handler = $handler
        ->withPutExtra('Path', '/admin/settings')
        ->withPutExtra('Payload', var_export($payload, true));
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
        file_put_contents(__DIR__ . '/output/' . $filename, $document);
    }
}
