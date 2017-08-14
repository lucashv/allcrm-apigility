<?php

namespace crm\V1\Rest\TelefonesContato;


use crm\Entity\TelefonesContato;
use crm\V1\Rest\AbstractService\AbstractService;

class TelefonesContatoFactory extends AbstractService
{
    protected $telefonesContatoEntity;

    public function __construct($em, $hydrator, $sm, TelefonesContato $telefonesContatoEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->sm = $sm;
        $this->telefonesContatoEntity = $telefonesContatoEntity;
    }

    public function create($telefone, int $idContato)
    {
        $contato = $this->em->getReference('crm\Entity\Contatos',$idContato);

        $this->telefonesContatoEntity->setContato($contato)
                                     ->setDataCriacao(new \DateTime("now"))
                                     ->setTelefone($telefone)
                                     ->setStatus(1);

        return $this->telefonesContatoEntity;


    }

}