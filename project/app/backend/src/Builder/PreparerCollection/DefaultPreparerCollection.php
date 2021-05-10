<?php
declare(strict_types=1);

namespace My\Builder\PreparerCollection;

use My\Builder\Preparer;
use My\Builder\PreparerCollection;

class DefaultPreparerCollection implements PreparerCollection
{
    /** @var array<Preparer> */
    protected array $preparers;

    public function __construct(Preparer ...$preparer)
    {
        $this->preparers = $preparer;
    }

    public function hasPreparers(): bool
    {
        return !empty($this->preparers);
    }

    public function prepareFieldName(string $fieldName): string
    {
        $formattedFieldName = $fieldName;
        foreach ($this->preparers as $preparer) {
            $formattedFieldName = $preparer->prepare($fieldName);
        }

        return $formattedFieldName;
    }
}