<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Task;



use App\Application\Task\Command\CreateTaskCommand;
use App\Application\Task\Handler\CreateTaskHandler;
use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateTaskHandlerTest extends TestCase
{
    public function testItCreatesNewTask(): void
    {
        $repository = $this->createMock(TaskRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Task::class));

        $handler = new CreateTaskHandler($repository);
        $command = new CreateTaskCommand('Read DDD book');

        $task = $handler($command);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertSame('Read DDD book', $task->getTitle()->value());
    }
}
