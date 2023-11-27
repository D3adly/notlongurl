<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Url\Add;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CreateUrlController extends AbstractController
{
    public function __construct(
        private readonly Add $urlAdd,
    ) {
    }

    #[Route('api/url', name: 'api_create_url', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $url = $this->urlAdd->createNewUrlEntry($data);
            return new JsonResponse(
                $url,
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }

    }




}
