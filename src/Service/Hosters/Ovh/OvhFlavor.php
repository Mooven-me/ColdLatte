<?php

namespace App\Service\Hosters\Ovh;

enum OvhFlavor : string {
    case RAM_16GB_VCPU_2 = "f60d6b10-28ac-4922-bdbd-dbb73243c000";
    case RAM_8GB_VCPU_4 = "da08411a-14f4-4ce1-842d-ca159a68d834";
}