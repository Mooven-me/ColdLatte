<?php

namespace App\Service\APIs;

use App\Model\Game\Game;
use App\Model\Game\Games;
use App\Service\APIs\ApiInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurseForgeApi implements ApiInterface{

    private HttpClientInterface $client;

    private array $excludeList = [
        5021, 4741, 5026, 5230, 5001
    ];

    public function __construct(
        #[Autowire(env: 'CURSEFORGE_API_KEY')] string $apiKey,
        HttpClientInterface $client,
    ) {
        // init the client
        $this->client = $client->withOptions(
            (new HttpOptions)
                ->setHeaders([
                    'Accept' => 'application/json',
                    'x-api-key' => $apiKey,
                ])
                ->setBaseUri("https://api.curseforge.com")
                ->toArray()
        );
    }

    /**
     * to get all the games the curseForgeAPI is connected to
     * @return Games the array of the games
     */
    public function getGames() : Games {
        $games = new Games();
        foreach($this->client->request('GET', '/v1/games')->toArray()['data'] as $gameArray){
            if(!in_array($gameArray['id'], $this->excludeList)){
                $games->add(new Game(
                    $gameArray['name'],
                    $gameArray['assets']['iconUrl'],
                    $gameArray['slug'],
                    $gameArray['assets']['coverUrl']
                ));
            }
        };
        return $games;
    }
}