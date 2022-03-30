<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VyhlaskyController extends AbstractController
{
    #[Route('/urad/dokumenty/vyhlasky', 'urad_dokumenty_vyhlasky')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_vyhlasky.html.twig');
    }
}
