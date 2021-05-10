<?php
declare(strict_types=1);

namespace My\Builder;

interface Builder
{
    public function build(int $useWay): object;

    public function clean(): void;
}
