<?php
declare(strict_types=1);

namespace My\Builder\Analyzer;

use My\Builder\Analyzer;
use ReflectionClass;
use ReflectionException;

class ConstructAnalyzer implements Analyzer
{
    public function can(object|string $model, string $fieldName): bool
    {
        try {
            $reflectionClass = new ReflectionClass($model);
        } catch (ReflectionException) {
            return false;
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return false;
        }

        $params = $constructor->getParameters();

        foreach ($params as $param) {
            if ($param->getName() === $fieldName) {
                return true;
            }
        }

        return false;
    }
}