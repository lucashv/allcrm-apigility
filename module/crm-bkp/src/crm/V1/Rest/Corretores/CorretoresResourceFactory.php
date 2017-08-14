<?php
namespace crm\V1\Rest\Corretores;

class CorretoresResourceFactory
{
    public function __invoke($services)
    {
        return new CorretoresResource($services->get('CorretoresService'));
    }
}
