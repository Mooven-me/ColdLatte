<?php

namespace App\Model\Game;
use Symfony\Component\Serializer\Attribute\Ignore;

abstract class Game{
    #[Ignore]
    public readonly array $apiResponse;

    public function __construct(array $apiResponse){
        $this->apiResponse = $apiResponse;
    }
    abstract public function getTitle(): string;
    abstract public function getImageUrl(): string;
    abstract public function getSlug(): string;
}