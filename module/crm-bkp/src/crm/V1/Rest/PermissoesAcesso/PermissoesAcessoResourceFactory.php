<?php
namespace crm\V1\Rest\PermissoesAcesso;

class PermissoesAcessoResourceFactory
{
    public function __invoke($services)
    {
        return new PermissoesAcessoResource($services->get('ModulosPermissaoAcessoService'));
    }
}
