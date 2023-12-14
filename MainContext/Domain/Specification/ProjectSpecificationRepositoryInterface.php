<?php

namespace ProjectManagement\MainContext\Domain\Specification;

interface ProjectSpecificationRepositoryInterface
{
    public function save(ProjectSpecification $specification);

    public function ofProjectId(string $projectId): ?ProjectSpecification;
}