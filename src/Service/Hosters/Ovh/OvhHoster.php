<?php

namespace App\Service\Hosters\Ovh;

use App\Model\Server\Server;
use App\Service\Hosters\HosterInterface;
use App\Service\Hosters\Ovh\OvhFlavor;
use Ovh\Api;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class OvhHoster implements HosterInterface {

    private Api $ovh;
    
    public function __construct(
        #[Autowire(env: 'OVH_CLIENT_ID')]
        private string $clientId,
        #[Autowire(env: 'OVH_CLIENT_SECRET')]
        private string $clientSecret,
        #[Autowire(env: 'OVH_SERVICE_ID')]
        private string $serviceId,
    ){
        print_r($clientId."fin");
        print_r($clientSecret);
        /** @var Api */
        $ovhApi = Api::withOAuth2($clientId, $clientSecret, 'ovh-eu');
        $this->ovh = $ovhApi;
    }

    public function host(Server $server) : void {
        $this->createInstance('test');
    }

    private function createInstance(string $name): array
    {
        return $this->ovh->post("/cloud/project/{$this->serviceId}/instance", [
            'flavorId'  => OvhFlavor::RAM_8GB_VCPU_4->value,
            'name'      => $name,
            'region'    => OvhRegion::GRA9->value,
            'imageId'     => OvhImage::DEBIAN12_DOCKER->value
        ]);
    }
}