<?php

namespace ProjectManagement\MainContext\Domain\Activity;

interface TaskActivityRepositoryInterface
{
    public function save(TaskActivity $task);

    public function ofTaskId(string $taskId): ?TaskActivity;
}