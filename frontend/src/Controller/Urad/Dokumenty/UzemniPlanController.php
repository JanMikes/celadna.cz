<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UzemniPlanController extends AbstractController
{
    #[Route('/urad/dokumenty/uzemni-plan', 'urad_dokumenty_uzemni_plan')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_uzemni_plan.html.twig');
    }
}
