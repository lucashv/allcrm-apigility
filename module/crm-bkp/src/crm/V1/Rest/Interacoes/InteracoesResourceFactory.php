<?php
namespace crm\V1\Rest\Interacoes;

class InteracoesResourceFactory
{
    public function __invoke($services)
    {
        return new InteracoesResource($services->get('InteracoesService'));
    }
}
