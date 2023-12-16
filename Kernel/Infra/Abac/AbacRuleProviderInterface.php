<?php

namespace ProjectManagement\Kernel\Infra\Abac;

interface AbacRuleProviderInterface
{
    public function provideBatch(): array;
}