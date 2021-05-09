<?php
declare(strict_types=1);

namespace My\Builder;

interface BuildManager
{
    public static function createBuilder(string $modelName): Builder;
}
