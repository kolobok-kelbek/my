<?php
declare(strict_types=1);

namespace My\Builder\Way;

use My\Builder\Exception\BuildException;
use ReflectionClass;
use ReflectionException;

class ReflectionWay extends Way
{
    public function pass(string|object $model, array $map): object
    {
        try {
            $reflectionClass = new ReflectionClass($model);
        } catch (ReflectionException $e) {
            $modelName = is_object($model) ? get_class($model) : $model;
            throw new BuildException("Build model \"{$modelName}\" is failed.", $e);
        }

        $instance = is_object($model) ? $model : $reflectionClass->newInstance();

        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            $value = $map[$property->getName()] ?? null;

            if ($value !== null) {
                $property->setAccessible(true);
                $property->setValue($instance, $value);
            }
        }

        return $instance;
    }
}
