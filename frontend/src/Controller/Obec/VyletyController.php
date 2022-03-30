<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VyletyController extends AbstractController
{
    #[Route('/obec/vylety', 'obec_vylety')]
    public function __invoke(): Response
    {
        return $this->render('obec_vylety.html.twig');
    }
}
