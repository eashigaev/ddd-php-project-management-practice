<?php

namespace ProjectManagement\MainContext\App;

enum TaskAction: string
{
    case AddTaskSpecification = 'AddTaskSpecification';
    case ChangeTaskSpecification = 'ChangeTaskSpecification';
    case EstimateTaskSpecification = 'EstimateTaskSpecification';
    case CloseTaskSpecification = 'CloseTaskSpecification';
    case OpenTaskActivity = 'OpenTaskActivity';
    case AssignTaskActivity = 'AssignTaskActivity';
    case EvaluateTaskActivity = 'EvaluateTaskActivity';
    case StartTaskActivity = 'StartTaskActivity';
    case StopTaskActivity = 'StopTaskActivity';
    case CompleteTaskActivity = 'CompleteTaskActivity';
    case CancelTaskActivity = 'CancelTaskActivity';
}