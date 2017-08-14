<?php
namespace crm\V1\Rest\TiposPlantoes;

class TiposPlantoesResourceFactory
{
    public function __invoke($services)
    {
        return new TiposPlantoesResource($services->get('TiposPlantoesService'));
    }
}
