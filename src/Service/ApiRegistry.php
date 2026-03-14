<?php

namespace App\Service;

use App\Service\APIs\ApiInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;

class ApiRegistry {

    public function __construct(
        #[AutowireLocator('app.apis', defaultIndexMethod: 'getType')]
        private ServiceLocator $apis
    ){}

    public function getApi(string $name): ApiInterface
    {
        if (!$this->apis->has($name)) {
            throw new \InvalidArgumentException(sprintf('The API "%s" is not supported.', $name));
        }

        $api = $this->apis->get($name);

        if (!$api instanceof ApiInterface) {
            throw new \LogicException(sprintf('The service "%s" must implement ApiInterface.', $name));
        }

        return $api;
    }
}