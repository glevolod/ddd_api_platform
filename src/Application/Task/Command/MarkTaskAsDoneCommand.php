<?php

declare(strict_types=1);

namespace App\Application\Task\Command;

final readonly class MarkTaskAsDoneCommand
{
    public function __construct(
        public string $taskId
    ) {
    }
}
