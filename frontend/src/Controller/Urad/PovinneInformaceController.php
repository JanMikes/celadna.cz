<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PovinneInformaceController extends AbstractController
{
    #[Route('/urad/povinne-informace', 'urad_povinne_informace')]
    public function __invoke(): Response
    {
        return $this->render('urad_povinne_informace.html.twig');
    }
}
