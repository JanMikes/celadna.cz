<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VyrocniZpravaController extends AbstractController
{
    #[Route('/urad/dokumenty/vyrocni-zprava', 'urad_dokumenty_vyrocni_zprava')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_vyrocni_zprava.html.twig');
    }
}
