<?php

namespace App\Service\Hosters;

use App\Model\Server\Server;
interface HosterInterface {
    public function host(Server $server): void;
}