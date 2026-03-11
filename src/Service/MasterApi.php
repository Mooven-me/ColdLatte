<?php

namespace App\Service;

use App\Model\Game\Games;
use App\Model\Server\Servers;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class MasterApi{
    /**
     * @param iterable<ApiInterface> $apis
     */
    public function __construct(
        #[AutowireIterator('app.apis')]
        private iterable $apis,
    ) {
    }

    public function getGames(): Games
    {
        $games = new Games();
        foreach($this->apis as $api){
            $games->merge($api->getGames());
        } 
        return $games;
    }

    public function getServers(string $slug): Servers {
        $servers = new Servers();
        foreach($this->apis as $api){
            $servers->merge($api->getServers($slug));
        } 
        return $servers;
    }
}