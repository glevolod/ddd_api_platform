<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use Symfony\Component\Uid\Uuid;

final class TaskId
{
    private function __construct(private readonly string $value) {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException('Invalid UUID format for TaskId');
        }
    }

    public static function create(): self
    {
        return new self(Uuid::v4()->toString());
    }

    public function fromString(string $id): self
    {
        return new self($id);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
