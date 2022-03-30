<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StrukturaUraduController extends AbstractController
{
    #[Route('/urad/struktura-uradu', 'urad_struktura_uradu')]
    public function __invoke(): Response
    {
        return $this->render('urad_struktura_uradu.html.twig');
    }
}
