<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailAktualityController extends AbstractController
{
    #[Route('/aktuality/{id}', 'detail_aktuality')]
    public function __invoke(): Response
    {
        return $this->render('detail_aktuality.html.twig');
    }
}
