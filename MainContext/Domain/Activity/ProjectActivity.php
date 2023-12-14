<?php

namespace ProjectManagement\MainContext\Domain\Activity;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;
use ProjectManagement\MainContext\Domain\Collaboration\ProjectRole;
use ProjectManagement\MainContext\Domain\Collaboration\ProjectTeam;
use ProjectManagement\MainContext\Domain\Specification\ProjectSpecification;

class ProjectActivity
{
    use OptimisticLockingTrait;

    public string $id;
    public string $projectId; //unique
    public bool $isStopped;

    public static function start(string $id, ProjectSpecification $specification, ProjectTeam $team): static
    {
        assert($specification->projectId === $team->projectId);

        $self = new static;
        $self->id = $id;
        $self->projectId = $specification->projectId;
        $self->isStopped = true;
        return $self;
    }

    public function stop(): void
    {
        assert(!$this->isStopped);

        $this->isStopped = true;
    }
}