<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VerejnopravniSmlouvyController extends AbstractController
{
    #[Route('/urad/dokumenty/verejnopravni-smlouvy', name: 'urad_dokumenty_verejnopravni_smlouvy')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_verejnopravni_smlouvy.html.twig');
    }
}
