<?php
namespace crm\V1\Rest\AgendaUsuario;

class AgendaUsuarioResourceFactory
{
    public function __invoke($services)
    {
        return new AgendaUsuarioResource($services->get('AgendaUsuarioService'));
    }
}
