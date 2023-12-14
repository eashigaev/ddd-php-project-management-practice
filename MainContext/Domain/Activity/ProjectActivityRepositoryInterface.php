<?php

namespace ProjectManagement\MainContext\Domain\Activity;

interface ProjectActivityRepositoryInterface
{
    public function save(ProjectActivity $activity);

    public function ofProjectId(string $projectId): ?ProjectActivity;
}