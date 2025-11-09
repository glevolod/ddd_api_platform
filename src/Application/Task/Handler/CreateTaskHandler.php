<?php

declare(strict_types=1);

namespace App\Application\Task\Handler;

use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskTitle;

final readonly class CreateTaskHandler
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(CreateTaskCommand $command): Task
    {
        $task = Task::create(new TaskTitle($command->title));

        $this->taskRepository->save($task);

        return $task;
    }
}
