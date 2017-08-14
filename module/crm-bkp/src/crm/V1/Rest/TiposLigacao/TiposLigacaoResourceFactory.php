<?php
namespace crm\V1\Rest\TiposLigacao;

class TiposLigacaoResourceFactory
{
    public function __invoke($services)
    {
        return new TiposLigacaoResource($services->get('TiposLigacoes'));
    }
}
