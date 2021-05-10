<?php
declare(strict_types=1);

namespace My\Builder\Analyzer;

use My\Builder\Analyzer;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class PublicFieldsAnalyzer implements Analyzer
{
    public function can(object|string $model, string $fieldName): bool
    {
        try {
            $reflectionClass = new ReflectionClass($model);
        } catch (ReflectionException) {
            return false;
        }

        try {
            $property = $reflectionClass->getProperty($fieldName);
        } catch (ReflectionException $e) {
            return false;
        }

        return $property->getModifiers() === ReflectionProperty::IS_PUBLIC;
    }
}