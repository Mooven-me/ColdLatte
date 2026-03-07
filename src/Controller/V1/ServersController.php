<?php

namespace App\Controller\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/servers')]
final class ServersController extends AbstractController
{
    #[Route('/', name: 'app_servers')]
    public function index(): Response
    {
        return new JsonResponse(["cucou"]);
    }
}
