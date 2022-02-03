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
use Chevere\Trace\Interfaces\TraceFormatInterface;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;

abstract class ThrowableHandlerFormat implements TraceFormatInterface
{
    protected VarDumpFormatInterface $varDumpFormatter;

    final public function __construct()
    {
        $this->varDumpFormatter = $this->getVarDumpFormat();
    }

    final public function varDumpFormat(): VarDumpFormatInterface
    {
        return $this->varDumpFormatter;
    }

    abstract public function getVarDumpFormat(): VarDumpFormatInterface;

    public function getTraceEntryTemplate(): string
    {
        return '#' . TraceDocumentInterface::TAG_ENTRY_POS .
            ' ' . TraceDocumentInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceDocumentInterface::TAG_ENTRY_CLASS .
            TraceDocumentInterface::TAG_ENTRY_TYPE .
            TraceDocumentInterface::TAG_ENTRY_FUNCTION;
    }

    public function getHr(): string
    {
        return '------------------------------------------------------------';
    }

    public function getLineBreak(): string
    {
        return "\n\n";
    }

    public function wrapLink(string $value): string
    {
        return $value;
    }

    public function wrapHidden(string $value): string
    {
        return $value;
    }

    public function wrapSectionTitle(string $value): string
    {
        return $value;
    }

    public function wrapTitle(string $value): string
    {
        return $value;
    }
}
