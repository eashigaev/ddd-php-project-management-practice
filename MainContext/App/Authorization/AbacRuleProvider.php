<?php

namespace ProjectManagement\MainContext\App\Authorization;

use ProjectManagement\Kernel\Infra\Abac\AbacRuleProviderInterface;
use ProjectManagement\MainContext\App\ProjectAction;
use ProjectManagement\MainContext\App\TaskAction;
use ProjectManagement\MainContext\Domain\Availability\AvailabilityServiceInterface;

readonly class AbacRuleProvider implements AbacRuleProviderInterface
{
    public function __construct(
        private AvailabilityServiceInterface $availabilityService
    )
    {
    }

    public function provideBatch(): array
    {
        return [
            function (array $attrs) {
                $action = ProjectAction::tryFrom($attrs['@name']);
                if (!$action) return null;
                if ($action === ProjectAction::AddProjectSpecification) return true;
                return !$this->availabilityService->isProjectAvailable($attrs['projectId']);
            },
            function (array $attrs) {
                $action = TaskAction::tryFrom($attrs['@name']);
                if (!$action) return null;
                if ($action === TaskAction::AddTaskSpecification) {
                    return $this->availabilityService->isProjectAvailable($attrs['projectId']);
                }
                return $this->availabilityService->isTaskAvailable($attrs['taskId']);
            }
        ];
    }
}