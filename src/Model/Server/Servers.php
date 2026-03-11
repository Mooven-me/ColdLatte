<?php

namespace App\Model\Server;

use IteratorAggregate;
use ArrayIterator;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use Traversable;

/**
 * to manage a list of Server
 * @template T of Server
 * @implements IteratorAggregate<int, Server>
 */
class Servers implements IteratorAggregate
{
    /** @var array<int, T> */
    #[Property(
        type: 'array',
        items: new Items(ref: new Model(type: Server::class)),
        description: 'An aggregated list of servers'
    )]
    public array $servers = [];

    /**
     * @property T $server
     */
    public function add(Server $server): void
    {
        $this->servers[] = $server;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->servers);
    }

    /**
     * to merge to Servers array
     */
    public function merge(Servers $servers){
        foreach($servers as $server){
            $this->servers[] = $server;
        }
    }
}