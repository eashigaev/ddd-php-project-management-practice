<?php

namespace ProjectManagement\MainContext\Domain;

interface PolicyServiceInterface
{
    public function isProjectActive(string $projectId): bool;

    public function isTaskActive(string $taskId): bool;
}