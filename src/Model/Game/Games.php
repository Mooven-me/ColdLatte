<?php

namespace App\Model\Game;

use IteratorAggregate;
use ArrayIterator;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use Traversable;

/**
 * to manage a list of Game
 * @implements IteratorAggregate<int, Game>
 */
class Games implements IteratorAggregate
{
    /** @var array<Game> */
    #[Property(
        type: 'array',
        items: new Items(ref: new Model(type: Game::class)),
        description: 'The aggregated list of games from all providers'
    )]
    public array $games = [];

    public function add(Game $game): void
    {
        $this->games[] = $game;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->games);
    }

    /**
     * to merge to Games array
     */
    public function merge(Games $games){
        foreach($games as $game){
            $this->games[] = $game;
        }
    }
}