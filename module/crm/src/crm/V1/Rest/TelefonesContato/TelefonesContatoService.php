<?php

namespace crm\V1\Rest\TelefonesContato;


use crm\V1\Rest\AbstractService\AbstractService;
use crm\V1\Rest\Filter\TelefoneFilter;

class TelefonesContatoService extends AbstractService
{

    protected $telefoneContatoFactory;

    public function __construct($em,$sm)
    {
        $this->em = $em;
        $this->repository = 'crm\Entity\TelefonesContato';
        $this->telefoneContatoFactory = $sm->get('TelefoneFactory');
    }

    public function getById($id)
    {
        return $this->padronizaRetorno( $this->em->getRepository($this->repository)->findBy(array('contato'=> $id)) );
    }

    public function insertTelefonesContatos($idContato, $data)
    {

        foreach ($data as $key => $object) {
            $telefone = $object['telefone'] ;
            $telefoneInserido = $this->em->getRepository($this->repository)->insertTelefonesContatos($idContato,$telefone, $this->telefoneContatoFactory);
            return $this->padronizaRetorno($telefoneInserido);
        }

    }

    public function padronizaRetorno($telefones)
    {
        $data = array();
        foreach($telefones as $telefone) {
            $data['telefones'][] =  TelefoneFilter::formataTelefone(false,$telefone->getTelefone()) ;
        }
        return $data;
    }

}