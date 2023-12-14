<?php

namespace ProjectManagement\MainContext\Domain;

interface PersonRepositoryInterface
{
    public function ofId(string $id): ?Person;
}