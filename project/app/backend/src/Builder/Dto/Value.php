<?php
declare(strict_types=1);

namespace My\Builder\Dto;

class Value
{
    private mixed $value;

    private ?int $way;

    public function __construct(mixed $value, ?int $way = null)
    {
        $this->value = $value;
        $this->way = $way;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getWay(): ?int
    {
        return $this->way;
    }
}