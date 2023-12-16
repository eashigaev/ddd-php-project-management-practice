<?php

namespace ProjectManagement\MainContext\App;

enum ProjectAction: string
{
    case AddProjectSpecification = 'AddProjectSpecification';
    case ChangeProjectSpecification = 'ChangeProjectSpecification';
    case CloseProjectSpecification = 'CloseProjectSpecification';
    case MakeProjectTeam = 'MakeProjectTeam';
    case AddProjectTeamMember = 'AddProjectTeamMember';
    case ChangeProjectTeamMemberRole = 'ChangeProjectTeamMemberRole';
    case RemoveProjectTeamMember = 'RemoveProjectTeamMember';
    case StartProjectActivity = 'StartProjectActivity';
    case StopProjectActivity = 'StopProjectActivity';
}