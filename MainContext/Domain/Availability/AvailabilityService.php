<?php

namespace ProjectManagement\MainContext\Domain\Availability;

use ProjectManagement\MainContext\Domain\Specification\ProjectSpecificationRepositoryInterface;
use ProjectManagement\MainContext\Domain\Specification\TaskSpecificationRepositoryInterface;

readonly class AvailabilityService implements AvailabilityServiceInterface
{
    public function __construct(
        private ProjectSpecificationRepositoryInterface $projectSpecificationRepository,
        private TaskSpecificationRepositoryInterface    $taskSpecificationRepository
    )
    {
    }

    public function isProjectAvailable(string $projectId): bool
    {
        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        return !$specification->isClosed;
    }

    public function isTaskAvailable(string $taskId): bool
    {
        $specification = $this->taskSpecificationRepository->ofTaskId($taskId);
        assert($specification);

        return !$specification->isClosed && $this->isProjectAvailable($specification->projectId);
    }
}