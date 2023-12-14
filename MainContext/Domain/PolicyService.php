<?php

namespace ProjectManagement\MainContext\Domain;

use ProjectManagement\MainContext\Domain\Activity\ProjectActivityRepositoryInterface;
use ProjectManagement\MainContext\Domain\Activity\TaskActivityRepositoryInterface;

readonly class PolicyService implements PolicyServiceInterface
{
    public function __construct(
        private ProjectActivityRepositoryInterface $projectActivityRepository,
        private TaskActivityRepositoryInterface    $taskActivityRepository,
    )
    {
    }

    public function isProjectActive(string $projectId): bool
    {
        $activity = $this->projectActivityRepository->ofProjectId($projectId);

        return !$activity || !$activity->isStopped;
    }

    public function isTaskActive(string $taskId): bool
    {
        $activity = $this->taskActivityRepository->ofTaskId($taskId);

        return $this->isProjectActive($activity->projectId) && (!$activity || !$activity->hasResult());
    }
}