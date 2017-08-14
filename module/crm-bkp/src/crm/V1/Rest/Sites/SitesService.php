<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 07/10/2015
 * Time: 11:17
 */

namespace crm\V1\Rest\Sites;


class SitesService
{

    public function __construct($em,$hydrator, $sitesEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->entity = $sitesEntity;
        $this->repository = 'crm\Entity\Sites';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT u.id, u.site FROM '.$this->repository.' u where u.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso n�o localizado");
    }

}
