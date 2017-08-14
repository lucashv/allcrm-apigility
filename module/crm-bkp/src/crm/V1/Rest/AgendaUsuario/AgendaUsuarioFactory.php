<?php

namespace crm\V1\Rest\AgendaUsuario;


use crm\Entity\AgendaUsuario;
use crm\V1\Rest\AbstractService\AbstractService;

class AgendaUsuarioFactory extends AbstractService
{
    protected $agendaUsuarioEntity;

    protected $em;

    public function __construct(AgendaUsuario $agendaUsuario, $em)
    {
        $this->agendaUsuarioEntity = $agendaUsuario;
        $this->em = $em;

    }

    public function create($params)
    {
        $this->agendaUsuarioEntity->setTitulo($params->titulo)
                                  ->setDescricao($params->descricao)
                                  ->setDataCriacao()
                                  ->setStatus(1);

        $dataAgenda = $params->dataAgenda;
        $dataAgenda =  new \DateTime($dataAgenda);
        $this->agendaUsuarioEntity->setDataAgenda($dataAgenda);


        $usuario = $this->em->getReference('crm\Entity\Usuarios', $params->idUsuario);

        $this->agendaUsuarioEntity->setUsuario($usuario);

        if(isset($params->idContato)) {

            $contato = $this->em->getReference('crm\Entity\Contatos', $params->idContato);
            $this->agendaUsuarioEntity->setContato($contato);
        }


        return $this->agendaUsuarioEntity;
    }

}