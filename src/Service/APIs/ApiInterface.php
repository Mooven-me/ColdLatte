<?php

namespace App\Service\APIs;

use App\Model\Game\Games;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use App\Model\Server\Server;
use App\Model\Server\Servers;

#[AutoconfigureTag('app.apis')]
interface ApiInterface
{
    /**
     * Fetch all games from the Api.
     * @return Games
     */
    public function getGames(): Games;

    /**
     * return all the servers list from a specified slug
     * @param string $slug the game's slug to get the servers from
     * @return Servers
     */
    public function getServers(string $slug) : Servers;
}