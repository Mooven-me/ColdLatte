<?php

namespace App\Service;

use App\Model\Game\Games;
use App\Service\APIs\ApiInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MasterApi{
    /**
     * @param iterable<ApiInterface> $apis
     */
    public function __construct(
        #[AutowireIterator('app.apis')]
        private iterable $apis,
        private CacheInterface $cache,
    ) {
    }

    public function getGames(): Games
    {
        return $this->cache->get('games', function (ItemInterface $item): Games {
            $item->expiresAfter(86400);
            $games = new Games();
            foreach($this->apis as $api){
                $games->merge($api->getGames());
            } 
            return $games;
        });
    }
}