<?php
declare(strict_types=1);

namespace My\Builder\Preparer;

use My\Builder\Preparer;

class SetterNameToFieldNamePreparer implements Preparer
{
    protected array $defaultSetterPrefixes = [
        'set',
        'has',
        'is',
    ];

    protected array $setterPrefixes;

    public function __construct(?array $setterPrefixes = null)
    {
        $this->setterPrefixes = $setterPrefixes ?? $this->defaultSetterPrefixes;
    }

    public function prepare(string $setterName): string
    {
        foreach ($this->setterPrefixes as $setterPrefix) {
            if (str_starts_with($setterName, $setterPrefix)) {
                return lcfirst(substr($setterName, strlen($setterPrefix)));
            }
        }

        return $setterName;
    }
}