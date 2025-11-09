<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Task\Entity;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\Event\TaskStatusChanged;
use App\Domain\Task\ValueObject\TaskId;
use App\Domain\Task\ValueObject\TaskStatus;
use App\Domain\Task\ValueObject\TaskTitle;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testCreateTask(): void
    {
        $title = new TaskTitle('Implement DDD');
        $task = Task::create($title);

        self::assertSame('Implement DDD', (string)$task->getTitle());
        self::assertSame('new', (string)$task->getStatus());

        $events = $task->releaseEvents();
        self::assertCount(1, $events);
        self::assertSame($task->getId()->toString(), $events[0]->id->toString());
    }

    public function testChangeStatusEmitsEvent(): void
    {
        $task = Task::create(new TaskTitle('Learn CQRS'));
        $task->clearEvents();

        $task->changeStatus(new TaskStatus(TaskStatus::IN_PROGRESS));

        self::assertSame('in_progress', (string)$task->getStatus());

        $events = $task->releaseEvents();
        self::assertCount(1, $events);
        self::assertInstanceOf(TaskStatusChanged::class, $events[0]);
        self::assertSame('new', (string)$events[0]->oldStatus);
        self::assertSame('in_progress', (string)$events[0]->newStatus);
    }
}
