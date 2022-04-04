<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ErrorController extends AbstractController
{
    public function __construct(
        private Content $content,
    ) {}


    public function __invoke(\Throwable $exception): Response
    {
        $template = 'error500.html.twig';

        if ($exception instanceof HttpException && $exception->getStatusCode() === 404) {
            $template = 'error404.html.twig';
        }

        return $this->render($template, [
            'footer' => $this->content->getFooterData(),
        ]);
    }
}
