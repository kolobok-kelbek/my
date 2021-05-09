<?php
declare(strict_types=1);

namespace My\Builder\Builder;

use InvalidArgumentException;
use My\Builder\Builder;
use My\Builder\Dto\Value;
use My\Builder\Exception\BuildException;
use My\Builder\Way;
use My\Builder\Ways;

class DefaultBuilder implements Builder
{
    protected string $modelName;

    /** @var array<Way> */
    protected array $ways;

    protected array $fieldNames = [];

    public function __construct(string $modelName, array $ways)
    {
        $this->modelName = $modelName;
        $this->ways = $ways;
    }

    public function __call(string $fieldName, array $arguments): self
    {
        if (empty($arguments[0])) {
            throw new InvalidArgumentException();
        }

        $this->fieldNames[$fieldName] = new Value(
            $arguments[0],
            $arguments[1] ?? null,
        );

        return $this;
    }

    public function build(int $useWay = Ways::ANY): object
    {
        $maps = [];
        foreach ($this->fieldNames as $fieldName => $value) {
            $maps[$value->getWay() ?? $useWay][$fieldName] = $value->getValue();
        }

        usort($this->ways, static fn(Way $a, Way $b): bool => $a->getPriority() > $b->getPriority());

        $subject = null;
        foreach ($this->ways as $way) {
            $wayCode = $way->getWayCode();
            foreach ($maps as $mapsKeyWayCode => $mapsKeyFieldNamesMap) {
                if ($wayCode & $mapsKeyWayCode) {
                    $fieldNames = $way->hasPreparerCollection()
                        ? $way->getPreparerCollection()->prepareFieldsNames($mapsKeyFieldNamesMap)
                        : $mapsKeyFieldNamesMap;

                    $subject = $way->pass($subject ?? $this->modelName, $fieldNames);
                }
            }
        }

        if ($subject === null) {
            throw new BuildException('Not found way for build.');
        }

        return $subject;
    }
}
