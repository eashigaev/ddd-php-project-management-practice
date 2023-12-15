<?php

namespace ProjectManagement\MainContext\Domain\Specification;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;

class TaskSpecification
{
    use OptimisticLockingTrait;

    public string $id;
    public string $projectId;
    public string $taskId; //unique
    public string $name;
    public string $description;
    public int $hours;
    public bool $isClosed;

    public static function add(string $id, ProjectSpecification $project, string $taskId, string $name, string $description): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $project->projectId;
        $self->taskId = $taskId;
        $self->name = $name;
        $self->description = $description;
        $self->hours = 0;
        $self->isClosed = false;
        return $self;
    }

    public function change(string $name, string $description): void
    {
        assert(!$this->isClosed);

        $this->name = $name;
        $this->description = $description;
    }

    public function estimate(int $hours): void
    {
        assert(!$this->isClosed);

        $this->hours = $hours;
    }

    public function close(): void
    {
        assert(!$this->isClosed);

        $this->isClosed = true;
    }
}