<?php

namespace ProjectManagement\MainContext\App;

use ProjectManagement\MainContext\Domain\Activity\ProjectActivity;
use ProjectManagement\MainContext\Domain\Activity\ProjectActivityRepositoryInterface;
use ProjectManagement\MainContext\Domain\Collaboration\ProjectRole;
use ProjectManagement\MainContext\Domain\Collaboration\ProjectTeam;
use ProjectManagement\MainContext\Domain\Collaboration\ProjectTeamRepositoryInterface;
use ProjectManagement\MainContext\Domain\PersonRepositoryInterface;
use ProjectManagement\MainContext\Domain\PolicyServiceInterface;
use ProjectManagement\MainContext\Domain\Specification\ProjectSpecification;
use ProjectManagement\MainContext\Domain\Specification\ProjectSpecificationRepositoryInterface;

readonly class ProjectAppService
{
    public function __construct(
        private PersonRepositoryInterface               $personRepository,
        private ProjectSpecificationRepositoryInterface $projectSpecificationRepository,
        private ProjectTeamRepositoryInterface          $projectTeamRepository,
        private ProjectActivityRepositoryInterface      $projectActivityRepository,
        private PolicyServiceInterface                  $policyService
    )
    {
    }

    // ProjectSpecification

    public function addProjectSpecification(string $name, string $code): void
    {
        $specification = ProjectSpecification::add(uniqid(), uniqid(), $name, $code);
        $this->projectSpecificationRepository->save($specification);
    }

    public function changeProjectSpecification(string $projectId, string $name, string $code): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        $specification->change($name, $code);
        $this->projectSpecificationRepository->save($specification);
    }

    public function closeProjectSpecification(string $projectId): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        $specification->close();
        $this->projectSpecificationRepository->save($specification);
    }

    // ProjectTeam

    public function makeProjectTeam(string $projectId, string $personId): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        $person = $this->personRepository->ofId($personId);
        assert($person);

        $team = ProjectTeam::make(uniqid(), $specification, $person);
        $this->projectTeamRepository->save($team);
    }

    public function addProjectTeamMember(string $projectId, string $personId, string $role): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $team = $this->projectTeamRepository->ofProjectId($projectId);
        assert($team);

        $person = $this->personRepository->ofId($personId);
        assert($person);

        $team->addMember($person, ProjectRole::from($role));
        $this->projectTeamRepository->save($team);
    }

    public function changeProjectTeamMemberRole(string $projectId, string $personId, string $role): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $team = $this->projectTeamRepository->ofProjectId($projectId);
        assert($team);

        $team->changeMemberRole($personId, ProjectRole::from($role));
        $this->projectTeamRepository->save($team);
    }

    public function removeProjectTeamMember(string $projectId, string $personId): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $team = $this->projectTeamRepository->ofProjectId($projectId);
        assert($team);

        $team->removeMember($personId);
        $this->projectTeamRepository->save($team);
    }

    // ProjectActivity

    public function startProjectActivity(string $projectId): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $specification = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($specification);

        $team = $this->projectTeamRepository->ofProjectId($projectId);
        assert($team);

        $activity = ProjectActivity::start(uniqid(), $specification, $team);
        $this->projectActivityRepository->save($activity);
    }

    public function stopProjectActivity(string $projectId): void
    {
        assert(!$this->policyService->isProjectClosed($projectId));

        $activity = $this->projectActivityRepository->ofProjectId($projectId);
        assert($activity);

        $activity->stop();
        $this->projectActivityRepository->save($activity);
    }
}