<?php

namespace ProjectManagement\MainContext\Domain\Availability;

interface AvailabilityServiceInterface
{
    public function isProjectAvailable(string $projectId): bool;

    public function isTaskAvailable(string $taskId): bool;
}