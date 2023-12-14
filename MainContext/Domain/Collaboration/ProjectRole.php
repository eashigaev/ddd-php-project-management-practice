<?php

namespace ProjectManagement\MainContext\Domain\Collaboration;

enum ProjectRole: string
{
    case MANAGER = 'MANAGER';
    case WORKER = 'WORKER';
}