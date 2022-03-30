<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UredniDeskaController extends AbstractController
{
    #[Route('/uredni-deska', 'uredni_deska')]
    public function __invoke(): Response
    {
        return $this->render('uredni_deska.html.twig');
    }
}
