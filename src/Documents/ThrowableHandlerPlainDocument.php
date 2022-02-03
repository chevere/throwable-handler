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

use Chevere\ThrowableHandler\Formats\ThrowableHandlerPlainFormat;
use Chevere\Trace\Interfaces\TraceFormatInterface;

final class ThrowableHandlerPlainDocument extends ThrowableHandlerDocument
{
    public function getFormat(): TraceFormatInterface
    {
        return new ThrowableHandlerPlainFormat();
    }
}
