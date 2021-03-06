<?php
declare(strict_types=1);

namespace My\Controller;

use ModelBuilder\Builder;
use My\Model\Data\Task;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('/', name: 'index')]
    public function index(Builder $taskBuilder): Task
    {
        $taskBuilder
            ->setTitle('this is task')
            ->setDescription('Lorem ...')
        ;

        return $taskBuilder->build();
    }
}
