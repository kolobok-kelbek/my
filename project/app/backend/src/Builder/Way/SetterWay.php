<?php
declare(strict_types=1);

namespace My\Builder\Way;

use My\Builder\Exception\BuildException;
use Throwable;

class SetterWay extends Way
{
    public function pass(string|object $model, array $map, ?object $preview = null): object
    {
        $objModel = is_object($model) ? $model : (new $model());
        try {
            foreach ($map as $setterName => $value) {
                $objModel->$setterName($value);
            }
        } catch (Throwable $e) {
            $modelName = is_object($model) ? get_class($model) : $model;
            throw new BuildException("Build model \"{$modelName}\" is failed.", $e);
        }

        return $objModel;
    }
}