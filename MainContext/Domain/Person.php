<?php

namespace ProjectManagement\MainContext\Domain;

use ProjectManagement\Kernel\Infra\OptimisticLockingTrait;

class Person
{
    use OptimisticLockingTrait;

    public string $id;

    public static function from(string $id): static
    {
        $self = new static;
        $self->id = $id;
        return $self;
    }
}