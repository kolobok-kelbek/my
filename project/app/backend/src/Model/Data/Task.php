<?php
declare(strict_types=1);

namespace My\Model\Data;

class Task
{
    private string $title;

    public string $description;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
