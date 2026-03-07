<?php

namespace App\Model\Game;

class Game{
    public function __construct(
        public readonly string $title,
        public readonly string $imageUrl,
        public readonly string $slug,
        public readonly ?string $coverUrl = null,
    ){
    }
}