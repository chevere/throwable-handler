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

namespace Chevere\ThrowableHandler\Documents;

use Chevere\ThrowableHandler\Formats\HtmlFormat;
use Chevere\ThrowableHandler\Interfaces\FormatInterface;

final class HtmlDocument extends ThrowableHandlerDocument
{
    public const NO_DEBUG_TITLE_PLAIN = 'Something went wrong';

    public const NO_DEBUG_CONTENT_HTML = <<<HTML
    <p>Please try again later. If the problem persist don't hesitate to contact the system administrator.</p>
    HTML;

    public const HTML_TEMPLATE = <<<HTML
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>%css%</style>
    </head>
    <body class="%bodyClass%">%body%</body>
    </html>
    HTML;

    public const NO_DEBUG_BODY_HTML = <<<HTML
    <main class="user-select-none"><div>%content%</div></main>
    HTML;

    public const DEBUG_BODY_HTML = <<<HTML
    <main class="main--stack"><div>%content%</div></main>
    HTML;

    public function getFormat(): FormatInterface
    {
        return new HtmlFormat();
    }

    public function getTemplate(): array
    {
        $template = parent::getTemplate();
        if (! $this->handler->isDebug()) {
            $template = [
                self::SECTION_TITLE => $template[self::SECTION_TITLE],
            ];
        }

        return $template;
    }

    public function getContent(string $content): string
    {
        return "<div>{$content}</div>";
    }

    public function getSectionTitle(): string
    {
        if (! $this->handler->isDebug()) {
            return $this->format->getWrapTitle(self::NO_DEBUG_TITLE_PLAIN)
                . self::NO_DEBUG_CONTENT_HTML
                . '<p><span class="user-select-all">'
                . self::TAG_DATE_TIME_UTC_ATOM
                . '</span> • <span class="user-select-all">'
                . self::TAG_ID
                . '</span></p>';
        }

        return $this->format->getWrapTitle(
            self::TAG_TITLE
            . ' <span>in&nbsp;'
            . self::TAG_FILE_LINE
            . '</span>'
        );
    }

    protected function prepare(string $document): string
    {
        $preDocument = strtr(self::HTML_TEMPLATE, [
            '%bodyClass%' => 'body--flex',
            '%css%' => file_get_contents(dirname(__DIR__) . '/src/template.css'),
            '%body%' => $this->handler->isDebug()
                ? self::DEBUG_BODY_HTML
                : self::NO_DEBUG_BODY_HTML,
        ]);

        return str_replace('%content%', $document, $preDocument);
    }
}
