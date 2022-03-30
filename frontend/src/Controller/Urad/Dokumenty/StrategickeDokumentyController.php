<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StrategickeDokumentyController extends AbstractController
{
    #[Route('/urad_dokumenty/strategicke-dokumenty', 'urad_dokumenty_strategicke_dokumenty')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_strategicke_dokumenty.html.twig');
    }
}
