<?php 

namespace App\Model\Server\APIs;

use App\Model\Server\Server;
use DateTime;
use Symfony\Component\Serializer\Attribute\Ignore;

class CurseForgeServer extends Server {
    public function getImageUrl(): string {
        return $this->apiResponse['logo']['thumbnailUrl'];
    }
    public function getSummary(): string {
        return $this->apiResponse['summary'];
    }
    
    public function getDownloadCount(): int {
        return $this->apiResponse['downloadCount'];
    }
    
    /**
     * @return array<int, string>
     */
    public function getCategories() : array {
        return array_map(fn($c) =>$c['name'] , $this->apiResponse['categories']);
    }

    public function getAuthor() : string {
        return $this->apiResponse['authors'][0]['name'] ?? "";
    }

    public function getDate() : ?string {
        if(empty($this->apiResponse['latestFiles'][0]['fileDate'])){
            return null;
        }
        return (new DateTime($this->apiResponse['latestFiles'][0]['fileDate']))->format('Y-m-d');
    }

    public function getVersion() : ?string {
        return $this->apiResponse['latestFiles'][0]['sortableGameVersions'][0]['gameVersionName'] ?? null;
    }

    public function getAdditionalData() : string {
        return $this->apiResponse['latestFiles'][0]['sortableGameVersions'][1]['gameVersionName'] ?? null;
    }
}