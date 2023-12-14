<?php

namespace ProjectManagement\MainContext\App;

use ProjectManagement\MainContext\Domain\Activity\TaskActivity;
use ProjectManagement\MainContext\Domain\Activity\TaskActivityRepositoryInterface;
use ProjectManagement\MainContext\Domain\PersonRepositoryInterface;
use ProjectManagement\MainContext\Domain\PolicyServiceInterface;
use ProjectManagement\MainContext\Domain\Specification\ProjectSpecificationRepositoryInterface;
use ProjectManagement\MainContext\Domain\Specification\TaskSpecification;
use ProjectManagement\MainContext\Domain\Specification\TaskSpecificationRepositoryInterface;

readonly class TaskAppService
{
    public function __construct(
        private PersonRepositoryInterface               $personRepository,
        private ProjectSpecificationRepositoryInterface $projectSpecificationRepository,
        private TaskSpecificationRepositoryInterface    $taskSpecificationRepository,
        private TaskActivityRepositoryInterface         $taskActivityRepository,
        private PolicyServiceInterface                  $policyService
    )
    {
    }

    // TaskSpecification

    public function addTaskSpecification(string $projectId, string $name, string $description): void
    {
        assert($this->policyService->isProjectActive($projectId));

        $project = $this->projectSpecificationRepository->ofProjectId($projectId);
        assert($project);

        $specification = TaskSpecification::add(
            uniqid(), $project, uniqid(), $name, $description
        );
        $this->taskSpecificationRepository->save($specification);
    }

    public function changeTaskSpecification(string $taskId, string $name, string $description): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $specification = $this->taskSpecificationRepository->ofTaskId($taskId);
        assert($specification);

        $specification->change($name, $description);
        $this->taskSpecificationRepository->save($specification);
    }

    public function estimateTaskSpecification(string $taskId, int $hours): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $specification = $this->taskSpecificationRepository->ofTaskId($taskId);
        assert($specification);

        $specification->estimate($hours);
        $this->taskSpecificationRepository->save($specification);
    }

    // TaskActivity

    public function openTaskActivity(string $taskId, string $personId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $specification = $this->taskSpecificationRepository->ofTaskId($taskId);
        assert($specification);

        $person = $this->personRepository->ofId($personId);
        assert($person);

        $activity = TaskActivity::open(uniqid(), $specification, $person);
        $this->taskActivityRepository->save($activity);
    }

    public function assignTaskActivity(string $taskId, string $personId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $person = $this->personRepository->ofId($personId);
        assert($person);

        $activity->assign($person);
        $this->taskActivityRepository->save($activity);
    }

    public function evaluateTaskActivity(string $taskId, int $hours, int $completion): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $activity->evaluate($hours, $completion);
        $this->taskActivityRepository->save($activity);
    }

    public function startTaskActivity(string $taskId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $activity->start();
        $this->taskActivityRepository->save($activity);
    }

    public function stopTaskActivity(string $taskId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $activity->stop();
        $this->taskActivityRepository->save($activity);
    }

    public function completeTaskActivity(string $taskId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $activity->complete();
        $this->taskActivityRepository->save($activity);
    }

    public function cancelTaskActivity(string $taskId): void
    {
        assert($this->policyService->isTaskActive($taskId));

        $activity = $this->taskActivityRepository->ofTaskId($taskId);
        assert($activity);

        $activity->cancel();
        $this->taskActivityRepository->save($activity);
    }
}