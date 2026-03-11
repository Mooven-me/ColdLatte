<?php

namespace App\Model\Util\Image;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;

#[DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        'class' => ClassImage::class
    ]
)]
abstract class Image {
    public function __construct(
        public string $image,
    ){
    }
}