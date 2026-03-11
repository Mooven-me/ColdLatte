<?php 

namespace App\Model\Game\APIs;

use App\Model\Game\Game;
use Symfony\Component\Serializer\Attribute\Ignore;

class CurseForgeGame extends Game {
    public function getTitle(): string {
        return $this->apiResponse['name'];
    }
    public function getCoverUrl(): string {
        return $this->apiResponse['assets']['coverUrl'];
    }
    public function getSlug(): string {
        return $this->apiResponse['slug'];
    }
    public function getImageUrl(): string {
        return $this->apiResponse['assets']['iconUrl'];
    }
    #[Ignore]
    public function getId(): int {
        return $this->apiResponse['id'];
    }
}