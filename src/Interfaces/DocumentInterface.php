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

use Stringable;

/**
 * Describes the component in charge of defining a throwable handler document.
 */
interface DocumentInterface extends Stringable
{
    public const SECTION_TITLE = 'title';

    public const SECTION_MESSAGE = 'message';

    public const SECTION_CHAIN = 'chain';

    public const SECTION_ID = 'id';

    public const SECTION_TIME = 'time';

    public const SECTION_EXTRA = 'extra';

    public const SECTION_STACK = 'stack';

    public const TAG_TITLE = '%title%';

    public const TAG_MESSAGE = '%message%';

    public const TAG_CODE_WRAP = '%codeWrap%';

    public const TAG_ID = '%id%';

    public const TAG_FILE_LINE = '%fileLine%';

    public const TAG_DATE_TIME_UTC_ATOM = '%dateTimeUtcAtom%';

    public const TAG_TIMESTAMP = '%timestamp%';

    public const TAG_STACK = '%stack%';

    public const TAG_PHP_UNAME = '%phpUname%';

    public const TAG_CHAIN = '%chain%';

    public const DISPLAY_ORDER = [
        self::SECTION_TITLE,
        self::SECTION_CHAIN,
        self::SECTION_MESSAGE,
        self::SECTION_EXTRA,
        self::SECTION_TIME,
        self::SECTION_ID,
        self::SECTION_STACK,
    ];

    public const SECTIONS_VERBOSITY = [
        self::SECTION_TITLE => 16,
        self::SECTION_CHAIN => 16,
        self::SECTION_MESSAGE => 16,
        self::SECTION_ID => 16,
        self::SECTION_TIME => 64,
        self::SECTION_STACK => 128,
    ];

    public function __construct(ThrowableHandlerInterface $throwableHandler);

    /**
     * Return an instance with the specified verbosity.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified verbosity.
     *
     * Calling this method will reset the document sections to fit the target verbosity.
     */
    public function withVerbosity(int $verbosity): static;

    /**
     * Provides access to the instance verbosity.
     */
    public function verbosity(): int;

    /**
     * Returns the document title section.
     */
    public function getSectionTitle(): string;

    /**
     * Returns the document message section.
     */
    public function getSectionMessage(): string;

    /**
     * Returns the document chain section.
     */
    public function getSectionChain(): string;

    /**
     * Returns the document id section.
     */
    public function getSectionId(): string;

    /**
     * Returns the document time section.
     */
    public function getSectionTime(): string;

    /**
     * Returns the document extra section.
     */
    public function getSectionExtra(): string;

    /**
     * Returns the document stack section.
     */
    public function getSectionStack(): string;

    /**
     * Returns a formatted content for a section.
     */
    public function getContent(string $content, string $handle = ''): string;

    /**
     * Returns the template used for translating placeholders tags.
     *
     * ```php
     * return [
     *     'self::::SECTION_TITLE' => $this->getSectionTitle(),
     * ];
     * ```
     * @return array<string, string>
     */
    public function getTemplate(): array;

    /**
     * Returns a new trace format instance.
     */
    public function getFormat(): FormatInterface;
}
