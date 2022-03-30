<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UradController extends AbstractController
{
    #[Route('/urad', 'urad')]
    public function __invoke(): Response
    {
        return $this->render('urad.html.twig');
    }
}
