<?php
namespace crm\V1\Rest\Usuarios;

class UsuariosResourceFactory
{
    public function __invoke($services)
    {
        return new UsuariosResource($services->get('UsuariosService'));
    }
}
