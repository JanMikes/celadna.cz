<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UzemniPlanController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/uzemni-plan', name: 'urad_dokumenty_uzemni_plan')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_uzemni_plan.html.twig', [
            'uzemni_plan' => $this->contentProvider->getUzemniPlanData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
