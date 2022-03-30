<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SluzbyController extends AbstractController
{
    #[Route('/obec/sluzby', 'obec_sluzby')]
    public function __invoke(): Response
    {
        return $this->render('obec_sluzby.html.twig');
    }
}
