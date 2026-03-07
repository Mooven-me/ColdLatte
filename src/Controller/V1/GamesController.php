<?php

namespace App\Controller\V1;

use App\Model\Game\Games;
use App\Service\MasterApi;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/games')]
final class ServerController extends AbstractController
{

    public function __construct(
        private MasterApi $mapi,
    ){
    }

    #[Route('/', name: 'games', methods:"GET")]
    #[Response(
        response: 200,
        description: "Returns an object containing the list of games",
        content: new JsonContent(
            ref: new Model(type: Games::class) 
        )
    )]
    public function games(): JsonResponse
    {
        return $this->json([
            'games' => $this->mapi->getGames()
        ]);
    }
}
