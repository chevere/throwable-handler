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

namespace Chevere\Tests\Formats;

use Chevere\ThrowableHandler\Formats\HtmlFormat;
use Chevere\ThrowableHandler\Formats\PlainFormat;
use PHPUnit\Framework\TestCase;

final class HtmlFormatTest extends TestCase
{
    public function testAgainstPlain(): void
    {
        $plainFormat = new PlainFormat();
        $htmlFormat = new HtmlFormat();
        $array = [
            'getItemTemplate' => [],
            'getHr' => [],
            'getLineBreak' => [],
            'getWrapLink' => ['value'],
            'getWrapHidden' => ['value'],
            'getWrapSectionTitle' => ['value'],
            'getWrapTitle' => ['value'],
        ];
        foreach ($array as $methodName => $args) {
            $plain = $plainFormat->{$methodName}(...$args);
            $html = $htmlFormat->{$methodName}(...$args);
            $this->assertSame($plain, strip_tags($html));
        }
    }

    public function testFormatting(): void
    {
        $htmlFormat = new HtmlFormat();
        $array = [
            'getItemTemplate' => [
                [],
                '<div class="pre pre--stack-entry %cssEvenClass%">%pos% %fileLine%'
                . "\n"
                . '%class%%type%%function%</div>',
            ],
            'getHr' => [
                [],
                '<div class="hr"><span>'
                . str_repeat('-', 60)
                . '</span></div>',
            ],
            'getLineBreak' => [
                [],
                "\n<br>\n",
            ],
            'getWrapLink' => [
                ['value'],
                'value',
            ],
            'getWrapHidden' => [
                ['value'],
                '<span class="hide">value</span>',
            ],
            'getWrapSectionTitle' => [
                ['value'],
                '<div class="title">value</div>',
            ],
            'getWrapSectionTitle' => [
                ['# value'],
                '<div class="title"><span class="hide">#&nbsp;</span>value</div>',
            ],
            'getWrapTitle' => [
                ['value'],
                '<div class="title title--scream">value</div>',
            ],
        ];
        foreach ($array as $methodName => $aux) {
            $args = $aux[0];
            $expected = $aux[1];
            $html = $htmlFormat->{$methodName}(...$args);
            $this->assertSame($expected, $html);
        }
    }
}
