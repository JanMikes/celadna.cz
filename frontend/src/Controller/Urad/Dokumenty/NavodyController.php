<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NavodyController extends AbstractController
{
    #[Route('/urad/dokumenty/navody', 'urad_dokumenty_navody')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_navody.html.twig');
    }
}
