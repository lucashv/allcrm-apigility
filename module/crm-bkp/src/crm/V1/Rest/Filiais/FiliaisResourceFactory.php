<?php
namespace crm\V1\Rest\Filiais;

class FiliaisResourceFactory
{
    public function __invoke($services)
    {
        return new FiliaisResource($services->get('FiliaisService'));
    }
}
