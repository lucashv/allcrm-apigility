<?php
namespace crm\V1\Rest\Fornecedores;
use crm\V1\Rest\AbstractService\AbstractService;

class FornecedoresService extends AbstractService
{
    protected $fornecedorEntity;

    public function __construct($em,$hydrator,$fornecedorEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->fornecedorEntity;
        $this->repository = 'crm\Entity\Fornecedores';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery
        ('
          SELECT
          f.id, f.nomeFantasia, f.razaoSocial, f.email, f.site
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