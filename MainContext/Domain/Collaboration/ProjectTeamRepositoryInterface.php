<?php

namespace ProjectManagement\MainContext\Domain\Collaboration;

interface ProjectTeamRepositoryInterface
{
    public function save(ProjectTeam $team);

    public function ofProjectId(string $projectId): ProjectTeam;
}