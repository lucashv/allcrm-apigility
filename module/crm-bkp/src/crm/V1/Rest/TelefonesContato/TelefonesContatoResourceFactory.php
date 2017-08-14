<?php
namespace crm\V1\Rest\TelefonesContato;

class TelefonesContatoResourceFactory
{
    public function __invoke($services)
    {
        return new TelefonesContatoResource($services->get('TelefonesContatoService'));
    }
}
