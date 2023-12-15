<?php

namespace ProjectManagement\MainContext\Domain;

interface PolicyServiceInterface
{
    public function isProjectClosed(string $projectId): bool;

    public function isTaskClosed(string $taskId): bool;
}