<?php

namespace App\Service\APIs;

use App\Model\Game\Games;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.apis')]
interface ApiInterface
{
    /**
     * Fetch all games from the specific API.
     * @return Games
     */
    public function getGames(): Games;
}