<?php
namespace crm\V1\Rest\OrigensInteracoes;

class OrigensInteracoesResourceFactory
{
    public function __invoke($services)
    {
        return new OrigensInteracoesResource($services->get('OrigensInteracoes'));
    }
}
