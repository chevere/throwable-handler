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

namespace Chevere\ThrowableHandler;

use Chevere\Message\Interfaces\MessageInterface;
use Chevere\Throwable\Exceptions\RangeException;
use Chevere\Throwable\Interfaces\ThrowableInterface;
use Chevere\ThrowableHandler\Interfaces\ThrowableReadInterface;
use ErrorException;
use Throwable;
use function Chevere\Message\message;

final class ThrowableRead implements ThrowableReadInterface
{
    private string $className;

    private string $code;

    private int $severity;

    private string $loggerLevel;

    private string $type;

    private MessageInterface $message;

    private string $file;

    private int $line;

    /**
     * @var array<array<string, mixed>>
     */
    private array $trace;

    private ?Throwable $previous;

    public function __construct(
        private Throwable $throwable
    ) {
        $this->className = $throwable::class;
        $this->code = strval($throwable->getCode());
        if ($throwable instanceof ErrorException) {
            $this->severity = $throwable->getSeverity();
            if ($this->code === '0') {
                $this->code = strval($this->severity);
            }
        } else {
            $this->severity = ThrowableReadInterface::DEFAULT_ERROR_TYPE;
        }
        $this->assertSeverity();
        $this->loggerLevel = ThrowableReadInterface::ERROR_LEVELS[$this->severity];
        $this->type = ThrowableReadInterface::ERROR_TYPES[$this->severity];
        $this->setMessage($throwable);
        $this->file = $throwable->getFile();
        $this->line = $throwable->getLine();
        $this->setTrace($throwable);
        $this->previous = $throwable->getPrevious();
    }

    public function throwable(): Throwable
    {
        return $this->throwable;
    }

    public function className(): string
    {
        return $this->className;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function severity(): int
    {
        return $this->severity;
    }

    public function loggerLevel(): string
    {
        return $this->loggerLevel;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function message(): MessageInterface
    {
        return $this->message;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function trace(): array
    {
        return $this->trace;
    }

    public function hasPrevious(): bool
    {
        return $this->previous !== null;
    }

    public function previous(): Throwable
    {
        // @phpstan-ignore-next-line
        return $this->previous;
    }

    private function assertSeverity(): void
    {
        $accepted = array_keys(ThrowableReadInterface::ERROR_TYPES);
        if (! in_array($this->severity, $accepted, true)) {
            throw new RangeException(
                message('Unknown severity value of %severity%, accepted values are: %accepted%')
                    ->withCode('%severity%', strval($this->severity))
                    ->withCode('%accepted%', implode(', ', $accepted))
            );
        }
    }

    private function setMessage(Throwable $throwable): void
    {
        if ($throwable instanceof ThrowableInterface) {
            $this->message = $throwable->message();
        } else {
            $this->message = message($throwable->getMessage());
        }
    }

    /**
     * @codeCoverageIgnore
     * @infection-ignore-all
     */
    private function setTrace(Throwable $throwable): void
    {
        $this->trace = $throwable->getTrace();
        if (($this->trace[0]['function'] ?? '') === ThrowableHandler::ERROR_AS_EXCEPTION) {
            array_shift($this->trace);
        }
        array_unshift($this->trace, [
            'function' => '{main}',
            'file' => $this->file,
            'line' => $this->line,
        ]);
    }
}
