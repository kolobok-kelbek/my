<?php
declare(strict_types=1);

namespace My\Builder\Manager;

use JetBrains\PhpStorm\Pure;
use My\Builder\Builder;
use My\Builder\BuildManager;
use My\Builder\Way;

class DefaultBuildManager implements BuildManager
{
    /** @var array<int, Way> */
    protected static array $wayMap = [];

    public function __construct(array $wayMap)
    {
        static::$wayMap = $wayMap;
    }

    #[Pure]
    public static function createBuilder(string $modelName): Builder
    {
        return new Builder\DefaultBuilder($modelName, static::$wayMap);
    }
}
