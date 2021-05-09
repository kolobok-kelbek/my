<?php
declare(strict_types=1);

namespace My\Builder;

interface PreparerCollection
{
    public function hasPreparers(): bool;

    public function prepareFieldsNames(array $fieldsNames): array;
}