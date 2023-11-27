<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Url;

class RedirectController extends AbstractController
{
    #[Route(path: '/{shortUrl}', name: 'redirect', methods: ['GET'])]
    public function __invoke(Url $url, Request $request): Response
    {
        return new RedirectResponse($url->getRealUrl());
    }
}
