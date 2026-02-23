<?php

namespace App\Controller;

use OpenApi\Attributes\JsonContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[Route('/api')]
final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard', methods:"GET")]
    #[Response(
        response: 200,
        description: "return dummy data",
        content: new JsonContent(
            properties:[
                new Property(property: 'message', type: 'string'),
                new Property(property: 'path', type: 'string'),
            ]
        )
    )]
    public function index(): JsonResponse
    {
        sleep(2);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DashboardController.php',
        ]);
    }
}
