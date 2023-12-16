<?php

namespace ProjectManagement\Kernel\Infra\Abac;

use ProjectManagement\Kernel\Infra\Authorizer\AuthorizerInterface;

readonly class AbacAuthorizer implements AuthorizerInterface
{
    public function __construct(
        private AbacEvaluatorInterface    $evaluator,
        private AbacRuleProviderInterface $ruleProvider
    )
    {
    }

    public function authorize(array $payload): void
    {
        $rules = $this->ruleProvider->provideBatch();
        $result = $this->evaluator->evaluate($payload, $rules);
        assert($result);
    }
}