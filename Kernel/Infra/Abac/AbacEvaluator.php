<?php

namespace ProjectManagement\Kernel\Infra\Abac;

class AbacEvaluator implements AbacEvaluatorInterface
{
    public function evaluate(array $attrs, array $rules): ?bool
    {
        $result = null;
        foreach ($rules as $rule) {
            $ruleResult = $rule($attrs);
            if ($ruleResult === false) {
                $result = false;
                break;
            }
            if ($ruleResult === true) {
                $result = true;
            }
        }
        return $result;
    }
}