<?php


namespace crm\V1\Rest\PermissoesAcesso;

use crm\V1\Rest\AbstractService\AbstractService;

/**
 * Classe responsavel pela validacao de acesso atraves do perfil do usuario.
 * Class PermissoesAcessoService
 * @package crm\V1\Rest\PermissoesAcesso
 */
class PermissoesAcessoService extends AbstractService
{

    public function __construct($em,$hydrator, $modolusPermissoesAcesso)
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->entity     = $modolusPermissoesAcesso;
        $this->repository = 'crm\Entity\ModulosPermissoes';
    }

    public function getPermissoesPerfil($idPerfil)
    {
        $perfil = $this->em->getRepository($this->repository)->findBy( array('perfil' =>$idPerfil ) );
        return $this->extractAll($perfil);
    }

}