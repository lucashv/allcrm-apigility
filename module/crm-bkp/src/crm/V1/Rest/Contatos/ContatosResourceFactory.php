<?php
namespace crm\V1\Rest\Contatos;

class ContatosResourceFactory
{
    public function __invoke($services)
    {
        return new ContatosResource($services->get('ContatosService'));
    }
}
