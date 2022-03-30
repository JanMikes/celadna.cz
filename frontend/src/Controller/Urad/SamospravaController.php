<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SamospravaController extends AbstractController
{
    #[Route('/urad/samosprava', 'urad_samosprava')]
    public function __invoke(): Response
    {
        return $this->render('urad_samosprava.html.twig');
    }
}
