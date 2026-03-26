<?php

namespace App\Controller\V1;

use App\Model\Server\Server;
use App\Model\Server\Servers;
use App\Service\ApiRegistry;
use App\Service\Hosters\Ovh\OvhHoster;
use App\Service\MasterApi;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/servers')]
final class ServersController extends AbstractController
{
    #[OA\Response(
        response: 200,
        description: 'Returns an object containing the list of the servers of a specifig game by its slug',
        content: new OA\JsonContent(
            ref: new Model(type: Servers::class)
        )
    )]
    #[Route('/{gameSlug}', name: 'servers', methods: 'GET')]
    public function servers(string $gameSlug, MasterApi $mapi): JsonResponse
    {
        return $this->json(['servers' => $mapi->getServers($gameSlug)]);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns an object containing a server',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'server',
                    ref: new Model(type: Server::class)
                )
            ])
    )]
    #[Route('/{apiSlug}/{serverId}', name: 'server', methods: 'GET')]
    public function server(string $apiSlug, string $serverId, ApiRegistry $apiRegistry){
        $api = $apiRegistry->getApi($apiSlug);
        return $this->json([
            'server' => $api->getServer($serverId)
        ]);
    }

    #[Route('/{apiSlug}/{serverId}', name: 'create_server', methods: 'POST')]
    public function createServer(string $apiSlug, string $serverId, ApiRegistry $apiRegistry, OvhHoster $ovh){
        $api = $apiRegistry->getApi($apiSlug);
        return $this->json([
            'status' => $api->createServer($serverId, $ovh)
        ]);
    }
}
