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

use Chevere\ThrowableHandler\Formats\ConsoleFormat;
use Chevere\ThrowableHandler\Interfaces\FormatInterface;
use Colors\Color;

final class ConsoleDocument extends ThrowableHandlerDocument
{
    public function getFormat(): FormatInterface
    {
        return new ConsoleFormat();
    }

    public function getSectionTitle(): string
    {
        return strtr('%t in %f', [
            '%t' => strval(
                // @phpstan-ignore-next-line
                (new Color(self::TAG_TITLE))->bold()->red()
            ),
            '%f' => $this->format->getWrapLink(self::TAG_FILE_LINE),
        ]);
    }
}
