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

use Chevere\ThrowableHandler\Interfaces\ThrowableHandlerFormatInterface;
use Chevere\Trace\Interfaces\TraceDocumentInterface;
use Chevere\VarDump\Interfaces\VarDumpFormatInterface;

abstract class ThrowableHandlerFormat implements ThrowableHandlerFormatInterface
{
    protected VarDumpFormatInterface $varDumpFormat;

    final public function __construct()
    {
        $this->varDumpFormat = $this->getVarDumpFormat();
    }

    final public function varDumpFormat(): VarDumpFormatInterface
    {
        return $this->varDumpFormat;
    }

    abstract public function getVarDumpFormat(): VarDumpFormatInterface;

    public function getItemTemplate(): string
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

    public function getNewLine(): string
    {
        return "\n";
    }

    public function getWrapNewLine(string $text): string
    {
        return $this->getNewLine()
            . $text
            . $this->getNewLine();
    }

    public function getLineBreak(): string
    {
        return str_repeat($this->getNewLine(), 2);
    }

    public function getWrapLink(string $value): string
    {
        return $value;
    }

    public function getWrapHidden(string $value): string
    {
        return $value;
    }

    public function getWrapSectionTitle(string $value): string
    {
        return $value;
    }

    public function getWrapTitle(string $value): string
    {
        return $value;
    }
}
