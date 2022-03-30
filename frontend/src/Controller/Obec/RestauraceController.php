<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RestauraceController extends AbstractController
{
    #[Route('/obec/restaurace', 'obec_restaurace')]
    public function __invoke(): Response
    {
        return $this->render('obec_restaurace.html.twig');
    }
}
