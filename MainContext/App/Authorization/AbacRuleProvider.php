<?php

namespace ProjectManagement\MainContext\App\Authorization;

use ProjectManagement\Kernel\Infra\Abac\AbacRuleProviderInterface;
use ProjectManagement\MainContext\App\ProjectAction;
use ProjectManagement\MainContext\App\TaskAction;
use ProjectManagement\MainContext\Domain\Reference\ReferenceServiceInterface;

readonly class AbacRuleProvider implements AbacRuleProviderInterface
{
    public function __construct(
        private ReferenceServiceInterface $referenceService
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
                return !$this->referenceService->isProjectClosed($attrs['projectId']);
            },
            function (array $attrs) {
                $action = TaskAction::tryFrom($attrs['@name']);
                if (!$action) return null;
                if ($action === TaskAction::AddTaskSpecification) {
                    return !$this->referenceService->isProjectClosed($attrs['projectId']);
                }
                return !$this->referenceService->isTaskClosed($attrs['taskId']);
            }
        ];
    }
}