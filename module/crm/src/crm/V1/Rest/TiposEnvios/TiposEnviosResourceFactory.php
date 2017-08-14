<?php
namespace crm\V1\Rest\TiposEnvios;

class TiposEnviosResourceFactory
{
    public function __invoke($services)
    {
        return new TiposEnviosResource($services->get('TiposEnviosService'));
    }
}
