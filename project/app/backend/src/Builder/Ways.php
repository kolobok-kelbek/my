<?php
declare(strict_types=1);

namespace My\Builder;

interface Ways
{
    public const PUBLIC_FIELDS = 1;
    public const CONSTRUCTOR = 2;
    public const SETTERS = 4;
    public const REFLECTION = 8;
    public const ANY = 15;
}
