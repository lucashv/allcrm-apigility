<?php

namespace crm\V1\Rest\Operadoras;


use crm\V1\Rest\AbstractService\AbstractService;

class OperadorasService extends AbstractService
{
    protected $operadoraEntity;

    public function __construct($em,$hydrator,$operadoraEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->fornecedorEntity = $operadoraEntity;
        $this->repository = 'crm\Entity\Operadoras';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery
        ('
          SELECT
           f.id,
           f.nomeFantasia,
           f.razaoSocial,
           f.cnpj,
           f.endereco
          FROM '.$this->repository.' f
          where f.status = 1
        ');

        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }
}