<?php

namespace crm\V1\Rest\TiposPlantoes;

use crm\V1\Rest\AbstractService\AbstractService;

class TipoPlantoesService extends AbstractService
{
    public function __construct($em,$hydrator, $tiposPlantoes)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->entity = $tiposPlantoes;
        $this->repository = 'crm\Entity\TiposPlantoes';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT u FROM '.$this->repository.' u where u.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

}