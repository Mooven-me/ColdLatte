<?php

namespace App\Service\APIs;

use App\Model\Game\Games;
use App\Service\APIs\ApiInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Model\Server\Servers;
use App\Model\Game\APIs\CurseForgeGame;
use App\Model\Server\APIs\CurseForgeServer;
use App\Service\Hosters\HosterInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CurseForgeApi implements ApiInterface{

    private HttpClientInterface $client;
    private array $excludeList = [
        5021, 4741, 5026, 5230, 5001
    ];

    public function __construct(
        #[Autowire(env: 'CURSEFORGE_API_KEY')] 
        private string $apiKey,
        HttpClientInterface $client,
        private CacheInterface $cache,
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

    public static function getType(): string{
        return 'curseforge';
    }

    /**
     * to get all the games the curseForgeAPI is connected to
     * @return Games<CurseForgeGame> the array of the games
     */
    public function getGames() : Games {
        return $this->cache->get('games', function (ItemInterface $item): Games {
            $item->expiresAfter(3600);
            $games = new Games();
            foreach($this->client->request('GET', '/v1/games')->toArray()['data'] as $gameArray){
                if(!in_array($gameArray['id'], $this->excludeList)){
                    $games->add(new CurseForgeGame($gameArray));
                }
            };
            return $games;
        });
    }

    /**
     * @param string $gameSlug
     * @return Servers<CurseForgeServer>
     */
    public function getServers(string $gameSlug) : Servers{
        $game = $this->getGames()->find($gameSlug);
        
        return $this->cache->get('servers.'.$gameSlug, function (ItemInterface $item) use ($game): Servers {
            $item->expiresAfter(3600);
            $servers = new Servers();
            $serversResponse = $this->client->request('GET', '/v1/mods/search', [
                'query' => [
                    'gameId'    => $game->getId(),
                    'classId'   => 4471,    // to specify 'modpack' section
                    'sortField' => 2,       // short by popularity
                    'sortOrder' => 'desc'
                ]
            ])
                ->toArray()['data'];
            foreach($serversResponse as $serverResponse){
                $servers->add(new CurseForgeServer($serverResponse));
            }
            return $servers;
        });
    }

    public function getServer(string $serverId) : CurseForgeServer {
        return $this->cache->get('servers.'.$serverId, function (ItemInterface $item) use ($serverId): CurseForgeServer {
            $item->expiresAfter(3600);
            $serverResponse = $this->client->request('GET', '/v1/mods/'.$serverId)
                ->toArray()['data'];
            return new CurseForgeServer($serverResponse);
        });
    }

    public function createServer(string $serverId, HosterInterface $hosterInterface) : mixed {
        $server = $this->getServer($serverId);
        $hosterInterface->host($server);
        return true;
    }
}