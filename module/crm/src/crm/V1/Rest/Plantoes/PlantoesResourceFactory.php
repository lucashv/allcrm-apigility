<?php
namespace crm\V1\Rest\Plantoes;

class PlantoesResourceFactory
{
    public function __invoke($services)
    {
        return new PlantoesResource($services->get('PlantoesService'));
    }
}
