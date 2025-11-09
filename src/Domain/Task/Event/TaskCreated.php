<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Task\ValueObject\TaskId;

final class TaskCreated
{
    public function __construct(
        public readonly TaskId $id,
        public readonly string $title,
        public readonly \DateTimeImmutable $occuredAt = new \DateTimeImmutable(),
    ) {
    }
}
