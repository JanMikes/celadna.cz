<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PristupnostController extends AbstractController
{
    #[Route('/pristupnost', 'pristupnost')]
    public function __invoke(): Response
    {
        return $this->render('pristupnost.html.twig');
    }
}
