<?php

namespace ProjectManagement\MainContext\Domain\Specification;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;

class ProjectSpecification
{
    use OptimisticLockingTrait;

    public string $id;
    public string $projectId; //unique
    public string $name;
    public string $code; //unique
    public bool $isClosed;

    public static function add(string $id, string $projectId, string $name, string $code): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $projectId;
        $self->name = $name;
        $self->code = $code;
        $self->isClosed = false;
        return $self;
    }

    public function change(string $name, string $code): void
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function close(): void
    {
        assert(!$this->isClosed);

        $this->isClosed = true;
    }
}