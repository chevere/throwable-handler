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
use Chevere\VarDump\Formats\ConsoleFormat as VarDumpConsoleFormat;
use Chevere\VarDump\Interfaces\FormatInterface as VarDumpFormatInterface;
use Colors\Color;

final class ConsoleFormat extends Format
{
    public function getVarDumpFormat(): VarDumpFormatInterface
    {
        return new VarDumpConsoleFormat();
    }

    public function getItemTemplate(): string
    {
        return $this->getWrapSectionTitle(
            '#' . TraceInterface::TAG_ENTRY_POS
        )
            . ' '
            . TraceInterface::TAG_ENTRY_FILE_LINE
            . "\n"
            . TraceInterface::TAG_ENTRY_CLASS
            . TraceInterface::TAG_ENTRY_TYPE
            . TraceInterface::TAG_ENTRY_FUNCTION;
    }

    public function getHr(): string
    {
        return strval(
            // @phpstan-ignore-next-line
            (new Color(str_repeat('-', 60)))->blue()
        );
    }

    public function getWrapLink(string $value): string
    {
        return strval(
            // @phpstan-ignore-next-line
            (new Color($value))->underline()->fg('blue')
        );
    }

    public function getWrapSectionTitle(string $value): string
    {
        return strval(
            // @phpstan-ignore-next-line
            (new Color($value))->green()
        );
    }
}
