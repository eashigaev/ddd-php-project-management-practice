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

    public static function add(string $id, ProjectSpecification $project, string $taskId, string $name, string $description): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $project->projectId;
        $self->taskId = $taskId;
        $self->name = $name;
        $self->description = $description;
        $self->hours = 0;
        return $self;
    }

    public function change(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function estimate(int $hours): void
    {
        $this->hours = $hours;
    }
}