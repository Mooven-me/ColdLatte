<?php

namespace App\Model\Util\Image;

use App\Model\Util\Color\Color;
class ClassImage extends Image {
    public function __construct(
        string $image,
        public ?Color $color = null 
    ){
        parent::__construct($image);
    }
}