<?php

namespace ProjectManagement\MainContext\Domain\Specification;

interface TaskSpecificationRepositoryInterface
{
    public function save(TaskSpecification $specification);

    public function ofTaskId(string $taskId): ?TaskSpecification;
}