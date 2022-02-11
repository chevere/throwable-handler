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

use Chevere\Trace\Interfaces\TraceDocumentInterface;
use Chevere\VarDump\Formats\VarDumpHtmlFormat;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;

final class ThrowableHandlerHtmlFormat extends ThrowableHandlerFormat
{
    public function getVarDumpFormat(): VarDumpFormatInterface
    {
        return new VarDumpHtmlFormat();
    }

    public function getItemTemplate(): string
    {
        return '<div class="pre pre--stack-entry ' .
            TraceDocumentInterface::TAG_ENTRY_CSS_EVEN_CLASS . '">#' .
            TraceDocumentInterface::TAG_ENTRY_POS . ' ' .
            TraceDocumentInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceDocumentInterface::TAG_ENTRY_CLASS .
            TraceDocumentInterface::TAG_ENTRY_TYPE .
            TraceDocumentInterface::TAG_ENTRY_FUNCTION .
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
