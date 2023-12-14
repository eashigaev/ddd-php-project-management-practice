<?php

namespace ProjectManagement\MainContext\Domain\Collaboration;

class ProjectMember
{
    public string $personId;
    public ProjectRole $role;

    public static function from(string $personId, ProjectRole $role): static
    {
        $self = new static;
        $self->personId = $personId;
        $self->role = $role;
        return $self;
    }
}