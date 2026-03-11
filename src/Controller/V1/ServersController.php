<?php

namespace App\Controller\V1;

use App\Model\Server\Servers;
use App\Service\MasterApi;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/servers')]
final class ServersController extends AbstractController
{
    public function __construct(
        private MasterApi $mapi,
    ){
    }

    #[Route('/{slug}', name: 'servers', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'Returns an object containing the list of the servers of a specifig game by its slug',
        content: new OA\JsonContent(
            ref: new Model(type: Servers::class)
        )
    )]
    public function index(string $slug): JsonResponse
    {
        return $this->json(['servers' => $this->mapi->getServers($slug)]);
    }
}
