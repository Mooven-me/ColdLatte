<?php

namespace App\Service\APIs;

use App\Model\Game\Games;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use App\Model\Server\Server;
use App\Model\Server\Servers;
use App\Service\Hosters\HosterInterface;

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
    public function getServers(string $gameSlug) : Servers;

    /**
     * return only one server related to the id of the server
     * @param string $serverId
     */
    public function getServer(string $serverId) : Server;

    /**
     * the type of the api is use in the url to find the current api that manage a server
     * @return string the api type
     */
    public static function getType(): string;

    /**
     * to create a server
     * @return mixed
     */
    public function createServer(string $serverId, HosterInterface $hosterInterface) : mixed;
}