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

    public static function add(string $id, string $projectId, string $name, string $code): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $projectId;
        $self->name = $name;
        $self->code = $code;
        return $self;
    }

    public function change(string $name, string $code): void
    {
        $this->name = $name;
        $this->code = $code;
    }
}