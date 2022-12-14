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

use function Chevere\Message\message;
use Chevere\Throwable\Exceptions\LogicException;

throw new LogicException(
    message("Don't %action% this is just a %context%.")
        ->withStrong('%action%', 'panic')
        ->withCode('%context%', 'drill'),
    previous: new RuntimeException('Oops!')
);
