<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 28/12/2015
 * Time: 12:21
 */

namespace crm\V1\Rest\TiposLigacao;


class TiposLigacaoService
{
    public function __construct($em,$hydrator, $tiposLigacoes)
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->entity     = $tiposLigacoes;
        $this->repository = 'crm\Entity\TiposLigacao';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT u.id, u.tipoLigacao FROM '.$this->repository.' u where u.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }
}