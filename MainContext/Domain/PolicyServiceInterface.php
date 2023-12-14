<?php

namespace ProjectManagement\MainContext\Domain;

interface PolicyServiceInterface
{
    public function isProjectLocked(string $projectId): bool;

    public function isTaskLocked(string $taskId): bool;
}