<?php

declare(strict_types=1);

namespace App\Application\Task\Handler;

use App\Application\Task\Command\MarkTaskAsDoneCommand;
use App\Domain\Task\Repository\TaskRepositoryInterface;

final readonly class MarkTaskAsDoneHandler
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(MarkTaskAsDoneCommand $command)
    {
        $task = $this->taskRepository->findById($command->taskId);

        if(!$task) {
            throw new \RuntimeException('Task not found: ' . $command->taskId);
        }

        $task->markAsDone();

        $this->taskRepository->save($task);
    }
}
