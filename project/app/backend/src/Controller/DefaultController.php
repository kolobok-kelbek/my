<?php
declare(strict_types=1);

namespace My\Controller;

use My\Builder\Builder;
use My\Builder\Ways;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Builder $taskBuilder): Response
    {
        $taskBuilder
            ->setTitle('this is task')
            ->setDescription('Lorem ...')
        ;

        return $this->json($taskBuilder->build(Ways::REFLECTION));
    }
}
