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

use Chevere\ThrowableHandler\Formats\PlainFormat;
use Chevere\ThrowableHandler\Interfaces\FormatInterface;

final class PlainDocument extends ThrowableHandlerDocument
{
    public function getFormat(): FormatInterface
    {
        return new PlainFormat();
    }
}
