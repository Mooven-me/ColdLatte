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
 * @template T of Game 
 * @implements IteratorAggregate<int, Game>
 */
class Games implements IteratorAggregate
{
    /** @var array<int, T> */
    #[Property(
        type: 'array',
        items: new Items(ref: new Model(type: Game::class)),
        description: 'An aggregated list of games'
    )]
    public array $games = [];

    /**
     * @param T $game
     */
    public function add(Game $game): void
    {
        $this->games[] = $game;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->games);
    }

    /**
     * to merge Games array with an other
     * @param Games $games the list of games
     */
    public function merge(Games $games) : void {
        foreach($games as $game){
            $this->games[] = $game;
        }
    }

    /**
     * Checks if a game with the given slug exists in the collection.
     * @param string $slug the slug to search into
     * @return bool if the value as been found or not
     */
    public function hasSlug(string $slug): bool
    {
        return array_any($this->games, fn(Game $game) => $game->getSlug() === $slug);
    }

    /**
     * @param string $slug
     * @return T|null
     */
    public function find(string $slug) : ?Game {
        return array_find($this->games, fn($g) => $g->getSlug() === $slug);
    }
}