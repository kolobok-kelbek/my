<?php
declare(strict_types=1);

namespace My\Builder\Builder;

use InvalidArgumentException;
use My\Builder\Analyzer;
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

    /** @var array<int, Analyzer> */
    protected array $analyzers;

    protected array $fieldNames = [];

    public function __construct(string $modelName, array $ways, array $analyzers)
    {
        $this->modelName = $modelName;
        $this->ways = $ways;
        $this->analyzers = $analyzers;
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
        usort($this->ways, static fn(Way $a, Way $b): bool => $a->getPriority() > $b->getPriority());

        $maps = $this->createFieldsMap($useWay);
        $subject = $this->buildSubject($maps);

        $this->clean();

        if ($subject === null) {
            throw new BuildException('Not found way for build.');
        }

        return $subject;
    }

    public function clean(): void
    {
        $this->fieldNames = [];
    }

    protected function createFieldsMap(int $useWay): array
    {
        $maps = [];

        if ($useWay === Ways::ANY) {
            $maxWayPriority = $this->ways[0]->getPriority();
            $lastPriorityWayCode = $this->ways[0]->getWayCode();

            foreach ($this->ways as $way) {
                if ($way->getPriority() > $maxWayPriority) {
                    $maxWayPriority = $way->getPriority();
                    $lastPriorityWayCode = $way->getWayCode();
                }
            }
        }

        foreach ($this->fieldNames as $fieldName => $value) {
            $wayCode = $value->getWay() ?? $useWay;
            $anyFound = false;
            if ($wayCode === Ways::ANY) {
                foreach ($this->ways as $way) {
                    if ($way->hasPreparerCollection()) {
                        $fieldName = $way->getPreparerCollection()->prepareFieldName($fieldName);
                    }
                    $analyzer = $this->analyzers[$way->getWayCode()] ?? null;

                    if ($analyzer !== null && $analyzer->can($this->modelName, $fieldName)) {
                        $maps[$way->getWayCode()][$fieldName] = $value->getValue();
                        $anyFound = true;
                        break;
                    }
                }
            }

            if (!$anyFound) {
                $commonWayCode = $lastPriorityWayCode ?? $useWay;

                foreach ($this->ways as $way) {
                    if ($commonWayCode === $way->getWayCode() && $way->hasPreparerCollection()) {
                        $fieldName = $way->getPreparerCollection()->prepareFieldName($fieldName);
                        break;
                    }
                }

                $maps[$commonWayCode][$fieldName] = $value->getValue();
            }
        }

        return $maps;
    }

    protected function buildSubject(array $maps): ?object
    {
        $subject = null;
        foreach ($this->ways as $way) {
            $wayCode = $way->getWayCode();

            if (!isset($maps[$wayCode])) {
                continue;
            }

            foreach ($maps as $mapsKeyWayCode => $fieldNames) {
                if ($wayCode & $mapsKeyWayCode) {
                    $subject = $way->pass($subject ?? $this->modelName, $fieldNames);
                }
            }
        }

        return $subject;
    }
}
