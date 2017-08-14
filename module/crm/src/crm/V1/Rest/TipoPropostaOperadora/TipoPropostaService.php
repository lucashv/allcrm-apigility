<?php

namespace crm\V1\Rest\TipoPropostaOperadora;


use crm\V1\Rest\AbstractService\AbstractService;

class TipoPropostaService extends AbstractService
{

    protected $em;

    protected $repository;


    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = 'crm\Entity\TipoPropostaOperadora';
    }

    public function fetchAll()
    {
        return $this->em->getRepository($this->repository)->getAll();
    }

}