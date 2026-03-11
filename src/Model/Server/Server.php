<?php

namespace App\Model\Server;

use App\Model\Util\Image\ClassImage;
use App\Model\Server\APIs\CurseForgeServer;
use App\Model\Util\Image\Image;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\Property;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Symfony\Component\Serializer\Attribute\Ignore;

#[DiscriminatorMap(
    typeProperty: 'api',
    mapping: [
        'curseforge' => CurseForgeServer::class
    ]
)]
class Server{
    #[Ignore]
    public readonly array $apiResponse;

    public function __construct(array $apiResponse){
        $this->apiResponse = $apiResponse;
    }
    public function getTitle(): string {
        return $this->apiResponse['name'];
    }
    public function getImageUrl(): string {
        return $this->apiResponse['image'];
    }
    public function getSlug(): string {
        return $this->apiResponse['slug'];
    }
    #[Property(ref: new Model(type: Image::class))]
    public function getApiLogo(): ClassImage {
        return new ClassImage('bi bi-cup-hot');
    }
}