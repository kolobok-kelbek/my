<?php
declare(strict_types=1);

namespace My\Builder\Way;

use My\Builder\Exception\BuildException;
use Throwable;

class PublicFieldsWay extends Way
{
    public function pass(string|object $model, array $map): object
    {
        $objModel = is_object($model) ? $model : (new $model());
        try {
            foreach ($map as $field => $value) {
                $objModel->$field = $value;
            }
        } catch (Throwable $e) {
            $modelName = is_object($model) ? get_class($model) : $model;
            throw new BuildException("Build model \"{$modelName}\" is failed.", $e);
        }

        return $objModel;
    }
}