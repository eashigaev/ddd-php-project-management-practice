<?php

namespace ProjectManagement\Kernel\Infra\Abac;

interface AbacEvaluatorInterface
{
    public function evaluate(array $attrs, array $rules): ?bool;
}