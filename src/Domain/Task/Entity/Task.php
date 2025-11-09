<?php

declare(strict_types=1);

namespace App\Domain\Task\Entity;

use App\Domain\Task\Event\TaskCreated;
use App\Domain\Task\Event\TaskStatusChanged;
use App\Domain\Task\ValueObject\TaskId;
use App\Domain\Task\ValueObject\TaskStatus;
use App\Domain\Task\ValueObject\TaskTitle;

final class Task
{
    private array $domainEvents = [];

    private function __construct(
        private readonly TaskId $id,
        private TaskTitle $title,
        private TaskStatus $status = new TaskStatus(TaskStatus::NEW)
    ) {
    }

    public static function create(TaskId $id, TaskTitle $title): self
    {
        $task = new self($id, $title);
        $task->recordEvent(new TaskCreated($id, (string)$title));
        return $task;
    }

    public function changeStatus(TaskStatus $newStatus): void
    {
        if ($this->status->equals($newStatus)) {
            return;
        }

        $oldStatus = $this->status;
        $this->status = $newStatus;

        $this->recordEvent(new TaskStatusChanged($this->id, $oldStatus, $newStatus));
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getTitle(): TaskTitle
    {
        return $this->title;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    /** @return object[] */
    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }

    private function recordEvent(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }

    /** @return object[] */
    public function releaseEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}
