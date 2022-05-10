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

use Chevere\ThrowableHandler\Interfaces\FormatInterface;
use Chevere\Trace\Interfaces\TraceInterface;
use Chevere\VarDump\Interfaces\FormatInterface as VarDumpFormatInterface;

abstract class Format implements FormatInterface
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
        return '#' . TraceInterface::TAG_ENTRY_POS .
            ' ' . TraceInterface::TAG_ENTRY_FILE_LINE . "\n" .
            TraceInterface::TAG_ENTRY_CLASS .
            TraceInterface::TAG_ENTRY_TYPE .
            TraceInterface::TAG_ENTRY_FUNCTION;
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
