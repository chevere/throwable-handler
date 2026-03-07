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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class HtmlFormatTest extends TestCase
{
    #[DataProvider('plainComparisonProvider')]
    public function testAgainstPlain(string $methodName, array $args): void
    {
        $plainFormat = new PlainFormat();
        $htmlFormat = new HtmlFormat();
        $plain = $plainFormat->{$methodName}(...$args);
        $html = $htmlFormat->{$methodName}(...$args);
        $this->assertSame($plain, strip_tags($html));
    }

    public static function plainComparisonProvider(): array
    {
        return [
            'getItemTemplate' => ['getItemTemplate', []],
            'getHr' => ['getHr', []],
            'getLineBreak' => ['getLineBreak', []],
            'getWrapLink' => ['getWrapLink', ['value']],
            'getWrapHidden' => ['getWrapHidden', ['value']],
            'getWrapSectionTitle' => ['getWrapSectionTitle', ['value']],
        ];
    }

    #[DataProvider('formattingProvider')]
    public function testFormatting(string $methodName, array $args, string $expected): void
    {
        $htmlFormat = new HtmlFormat();
        $html = $htmlFormat->{$methodName}(...$args);
        $this->assertSame($expected, $html);
    }

    public static function formattingProvider(): array
    {
        return [
            'getItemTemplate' => [
                'getItemTemplate',
                [],
                '<div class="pre pre--stack-entry %cssEvenClass%">%pos% %fileLine%'
                . "\n"
                . '%class%%type%%function%</div>',
            ],
            'getHr' => [
                'getHr',
                [],
                '<div class="hr"><span>'
                . str_repeat('-', 60)
                . '</span></div>',
            ],
            'getLineBreak' => [
                'getLineBreak',
                [],
                "\n<br>\n",
            ],
            'getWrapLink' => [
                'getWrapLink',
                ['value'],
                'value',
            ],
            'getWrapHidden' => [
                'getWrapHidden',
                ['value'],
                '<span class="hide">value</span>',
            ],
            'getWrapSectionTitle default' => [
                'getWrapSectionTitle',
                ['value'],
                '<div class="title">value</div>',
            ],
            'getWrapSectionTitle with hash' => [
                'getWrapSectionTitle',
                ['# value'],
                '<div class="title"><span class="hide">##&nbsp;</span>value</div>',
            ],
            'getWrapTitle' => [
                'getWrapTitle',
                ['value'],
                '<div class="title title--scream"><span class="hide">#&nbsp;</span>value</div>',
            ],
        ];
    }
}
