<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Task\ValueObject\TaskId;
use App\Domain\Task\ValueObject\TaskStatus;

final class TaskStatusChanged
{
    public function __construct(
        public readonly TaskId $id,
        public readonly TaskStatus $oldStatus,
        public readonly TaskStatus $newStatus,
        public readonly \DateTimeImmutable $occurredAt = new \DateTimeImmutable(),
    ) {
    }
}
