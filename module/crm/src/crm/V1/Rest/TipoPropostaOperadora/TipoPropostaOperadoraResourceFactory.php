<?php
namespace crm\V1\Rest\TipoPropostaOperadora;

class TipoPropostaOperadoraResourceFactory
{
    public function __invoke($services)
    {
        return new TipoPropostaOperadoraResource($services->get('TipoPropostaService'));
    }
}
