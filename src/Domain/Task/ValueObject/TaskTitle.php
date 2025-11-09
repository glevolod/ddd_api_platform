<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

final class TaskTitle
{
    public function __construct(private string $value) {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('Task title cannot be empty');
        }

        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException('Task title cannot be longer than 255 characters');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
