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

namespace Chevere\ThrowableHandler\Formats;

use Chevere\Trace\Interfaces\TraceInterface;
use Chevere\VarDump\Formats\HtmlFormat as VarDumpHtmlFormat;
use Chevere\VarDump\Interfaces\FormatInterface as VarDumpFormatInterface;

final class HtmlFormat extends Format
{
    public function getVarDumpFormat(): VarDumpFormatInterface
    {
        return new VarDumpHtmlFormat();
    }

    public function getItemTemplate(): string
    {
        return '<div class="pre pre--stack-entry ' .
            TraceInterface::TAG_ENTRY_CSS_EVEN_CLASS . '">#' .
            TraceInterface::TAG_ENTRY_POS . ' ' .
            TraceInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceInterface::TAG_ENTRY_CLASS .
            TraceInterface::TAG_ENTRY_TYPE .
            TraceInterface::TAG_ENTRY_FUNCTION .
            '</div>';
    }

    public function getHr(): string
    {
        return '<div class="hr"><span>'
            . str_repeat('-', 60)
            . '</span></div>';
    }

    public function getLineBreak(): string
    {
        return "\n<br>\n";
    }

    public function getWrapHidden(string $value): string
    {
        return '<span class="hide">' . $value . '</span>';
    }

    public function getWrapSectionTitle(string $value): string
    {
        return '<div class="title">'
            . str_replace('# ', $this->getWrapHidden('#&nbsp;'), $value)
            . '</div>';
    }

    public function getWrapTitle(string $value): string
    {
        return '<div class="title title--scream">' . $value . '</div>';
    }
}
