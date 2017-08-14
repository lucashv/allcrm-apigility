<?php

namespace crm\V1\Rest\EmailsContato;


use crm\Entity\EmailsContato;
use crm\V1\Rest\AbstractService\AbstractService;

class EmailContatoService extends AbstractService
{
    protected $emailEntity;

    public function __construct($em,$hydrator, EmailsContato $emailEntity)
    {
        $this->em          = $em;
        $this->hydrator    = $hydrator;
        $this->emailEntity = $emailEntity;
        $this->repository  = 'crm\Entity\EmailsContato';
    }

    public function getById($id)
    {
        return $this->padronizaRetorno( $this->em->getRepository($this->repository)->findBy(array('contato'=> $id)) );
    }

    public function padronizaRetorno($emails)
    {
        $data = array();
        foreach($emails as $email) {
            $data['emails'][] =  $email->getEmail() ;
        }
        return $data;
    }

}