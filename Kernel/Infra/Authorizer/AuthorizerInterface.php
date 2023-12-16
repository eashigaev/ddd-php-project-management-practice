<?php

namespace ProjectManagement\Kernel\Infra\Authorizer;

interface AuthorizerInterface
{
    public function authorize(array $payload): void;
}