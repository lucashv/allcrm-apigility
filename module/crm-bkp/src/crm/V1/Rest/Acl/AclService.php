<?php
namespace crm\V1\Rest\Acl;


use crm\Entity\ModulosPermissoes;
use crm\V1\Rest\AbstractService\AbstractService;

class AclService extends AbstractService
{
    public function __construct($em,$hydrator, ModulosPermissoes $modulosPermissoes )
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->entity     = $modulosPermissoes;
        $this->repository = 'crm\Entity\ModulosPermissoes';
    }

    public function fetch($parametros)
    {
        if($parametros->tipo == 'getByPerfil')
        {
            return $this->em->getRepository($this->repository)->getByPerfil($parametros->idPerfil);

        }

    }


}