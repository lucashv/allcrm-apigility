<?php
namespace crm\V1\Rest\ContatoCorretorBloqueio;

class ContatoCorretorBloqueioResourceFactory
{
    public function __invoke($services)
    {
        return new ContatoCorretorBloqueioResource($services->get('ContatoBloqueioService'));
    }
}
