<?php

namespace ProjectManagement\MainContext\Domain;

use ProjectManagement\MainContext\Domain\Specification\ProjectSpecificationRepositoryInterface;
use ProjectManagement\MainContext\Domain\Specification\TaskSpecificationRepositoryInterface;

readonly class PolicyService implements PolicyServiceInterface
{
    public function __construct(
        private ProjectSpecificationRepositoryInterface $projectSpecificationRepository,
        private TaskSpecificationRepositoryInterface    $taskSpecificationRepository
    )
    {
    }

    public function isProjectClosed(string $projectId): bool
    {
        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        return $specification->isClosed;
    }

    public function isTaskClosed(string $taskId): bool
    {
        $specification = $this->taskSpecificationRepository->ofTaskId($taskId);
        assert($specification);

        return $specification->isClosed || $this->isProjectClosed($specification->projectId);
    }
}