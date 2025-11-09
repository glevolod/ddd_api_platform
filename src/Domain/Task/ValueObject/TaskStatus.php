<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

final class TaskStatus
{
    public const NEW = 'new';
    public const IN_PROGRESS = 'in_progress';
    public const DONE = 'done';

    private const ALLOWED = [
        self::NEW,
        self::IN_PROGRESS,
        self::DONE,
    ];

    public function __construct(private readonly string $value)
    {
        if (!in_array($value, self::ALLOWED, true)) {
            throw new \InvalidArgumentException('Invalid status');
        }
    }

    public static function new(): self {
        return new self(self::NEW);
    }

    public static function inProgress(): self
    {
        return new self(self::IN_PROGRESS);
    }

    public static function done(): self
    {
        return new self(self::DONE);
    }

    public function value(): string {
        return $this->value;
    }

    public function equals(self $other): bool {
        return $this->value === $other->value;
    }
    public function __toString(): string {
        return $this->value;
    }
}
