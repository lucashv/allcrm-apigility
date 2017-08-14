<?php
namespace crm\V1\Rest\SituacoesInteracoes;

class SituacoesInteracoesResourceFactory
{
    public function __invoke($services)
    {
        return new SituacoesInteracoesResource($services->get('SituacoesInteracoes'));
    }
}
