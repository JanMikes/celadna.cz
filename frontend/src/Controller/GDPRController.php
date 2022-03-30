<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GDPRController extends AbstractController
{
    #[Route('/gdpr', 'gdpr')]
    public function __invoke(): Response
    {
        return $this->render('gdpr.html.twig');
    }
}
