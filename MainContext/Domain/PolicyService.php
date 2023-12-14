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

    public function isProjectLocked(string $projectId): bool
    {
        $activity = $this->projectActivityRepository->ofProjectId($projectId);

        return $activity && $activity->isStopped;
    }

    public function isTaskLocked(string $taskId): bool
    {
        $activity = $this->taskActivityRepository->ofTaskId($taskId);

        return ($activity && $activity->hasResult()) || $this->isProjectLocked($activity->projectId);
    }
}