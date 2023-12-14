<?php

namespace ProjectManagement\MainContext\Domain\Collaboration;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;
use ProjectManagement\MainContext\Domain\Person;
use ProjectManagement\MainContext\Domain\Specification\ProjectSpecification;

class ProjectTeam
{
    use OptimisticLockingTrait;

    public string $id;
    public string $projectId; //unique
    public array $members;

    public static function make(string $id, ProjectSpecification $specification, Person $person): static
    {
        $self = new static;
        $self->id = $id;
        $self->projectId = $specification->projectId;
        $self->members = [];
        $self->addMember($person, ProjectRole::MANAGER);
        return $self;
    }

    public function addMember(Person $person, ProjectRole $role): void
    {
        $found = $this->filterMembers(
            fn(ProjectMember $member) => $member->personId === $person->id
        );
        assert(!$found);
        $this->members[] = ProjectMember::from($person->id, $role);
    }

    public function changeMemberRole(string $personId, ProjectRole $role): void
    {
        $this->members = $this->filterMembers(
            fn(ProjectMember $member) => $member->personId !== $personId
        );
        $this->members[] = ProjectMember::from($personId, $role);
        assert($this->filterMembersByRoles([ProjectRole::MANAGER]));
    }

    public function removeMember(string $personId): void
    {
        $this->members = $this->filterMembers(
            fn(ProjectMember $member) => $member->personId !== $personId
        );
        assert($this->filterMembersByRoles([ProjectRole::MANAGER]));
    }

    //

    public function filterMembersByRoles(array $roles): array
    {
        return $this->filterMembers(
            fn(ProjectMember $member) => in_array($member->role, $roles)
        );
    }

    public function filterMembers(callable $callback): array
    {
        return array_filter($this->members, $callback);
    }
}