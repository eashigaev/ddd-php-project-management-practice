<?php

namespace ProjectManagement\MainContext\Domain\Reference;

interface ReferenceServiceInterface
{
    public function isProjectClosed(string $projectId): bool;

    public function isTaskClosed(string $taskId): bool;
}