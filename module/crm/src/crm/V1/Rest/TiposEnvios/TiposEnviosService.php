<?php
namespace crm\V1\Rest\TiposEnvios;


use crm\V1\Rest\AbstractService\AbstractService;

class TiposEnviosService extends AbstractService
{
    public function __construct($em,$hydrator, $tiposEnvioEntity)
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->entity     = $tiposEnvioEntity;
        $this->repository = 'crm\Entity\TiposEnvio';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT t.id, t.tipoEnvio FROM '.$this->repository.' t where t.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

}