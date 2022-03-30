<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class KontaktyController extends AbstractController
{
    #[Route('/urad/kontakty', 'urad_kontakty')]
    public function __invoke(): Response
    {
        return $this->render('urad_kontakty.html.twig');
    }
}
