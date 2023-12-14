<?php

namespace ProjectManagement\MainContext\Domain\Activity;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;
use ProjectManagement\MainContext\Domain\Person;
use ProjectManagement\MainContext\Domain\Specification\TaskSpecification;

class TaskActivity
{
    use OptimisticLockingTrait;

    public string $id;
    public string $projectId;
    public string $taskId; //unique
    public string $assigneeId;
    public ?bool $result;

    public int $hours = 0;
    public int $completion = 0;
    public bool $inProgress;

    public static function open(string $id, TaskSpecification $specification, Person $person): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $specification->projectId;
        $self->taskId = $specification->taskId;
        $self->result = null;
        $self->inProgress = false;
        $self->hours = 0;
        $self->completion = 0;
        $self->assign($person);
        return $self;
    }

    //

    public function start(): void
    {
        assert(!$this->hasResult() && !$this->inProgress);

        $this->inProgress = true;
    }

    public function stop(): void
    {
        assert(!$this->hasResult() && $this->inProgress);

        $this->inProgress = false;
    }

    public function assign(Person $person): static
    {
        assert(!$this->hasResult());

        $this->assigneeId = $person->id;
    }

    public function evaluate(int $hours, int $completion): static
    {
        assert(!$this->hasResult());

        $this->hours = $hours;
        $this->completion = $completion;
    }

    //

    public function hasResult(): bool
    {
        return !is_null($this->result);
    }

    public function complete(): void
    {
        assert(!$this->hasResult());

        $this->inProgress = false;
        $this->result = true;
    }

    public function cancel(): void
    {
        assert(!$this->hasResult());

        $this->inProgress = false;
        $this->result = false;
    }
}