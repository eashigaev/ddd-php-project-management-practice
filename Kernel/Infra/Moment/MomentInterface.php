<?php

namespace ProjectManagement\Kernel\Infra\Moment;

use DateTime;

interface MomentInterface
{
    public function now(): DateTime;
}