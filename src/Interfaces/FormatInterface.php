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

namespace Chevere\ThrowableHandler\Interfaces;

use Chevere\Trace\Interfaces\FormatInterface as TraceFormatInterface;
use Chevere\VarDump\Interfaces\FormatInterface as VarDumpFormatInterface;

/**
 * Describes the component in charge of defining a throwable handler format.
 */
interface FormatInterface extends TraceFormatInterface
{
    public function __construct();

    public function getVarDumpFormat(): VarDumpFormatInterface;

    public function getWrapSectionTitle(string $value): string;

    public function getWrapTitle(string $value): string;
}
