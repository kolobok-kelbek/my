<?php
declare(strict_types=1);

namespace My\Builder\Way;

use My\Builder\PreparerCollection;

abstract class Way implements \My\Builder\Way
{
    protected int $wayCode;

    protected int $priority;

    protected ?PreparerCollection $preparerCollection;

    public function __construct(int $wayCode, int $priority, ?PreparerCollection $formatters = null)
    {
        $this->wayCode = $wayCode;
        $this->priority = $priority;
        $this->preparerCollection = $formatters;
    }

    public function getWayCode(): int
    {
        return $this->wayCode;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function hasPreparerCollection(): bool
    {
        return $this->preparerCollection !== null && $this->preparerCollection->hasPreparers();
    }

    public function getPreparerCollection(): ?PreparerCollection
    {
        return $this->preparerCollection;
    }
}
