<?php
declare(strict_types=1);

namespace My\Builder;

interface Preparer
{
    public function prepare(string $setterName): string;
}
