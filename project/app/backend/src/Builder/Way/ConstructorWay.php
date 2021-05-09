<?php
declare(strict_types=1);

namespace My\Builder\Way;

use My\Builder\Exception\BuildException;
use ReflectionClass;
use ReflectionException;

class ConstructorWay extends Way
{
    public function pass(string|object $model, array $map): object
    {
        if (is_object($model)) {
            return $model;
        }

        try {
            $reflectionClass = new ReflectionClass($model);
        } catch (ReflectionException $e) {
            throw new BuildException("Build model \"{$model}\" is failed.", $e);
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor !== null) {
            $params = $constructor->getParameters();

            return $reflectionClass->newInstance(...array_map(fn($param) => $map[$param->getName()], $params));
        }

        throw new BuildException("Not found constructor.");
    }
}