<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 21/12/2015
 * Time: 19:43
 */

namespace crm\V1\Rest\Filiais;


use crm\V1\Rest\AbstractService\AbstractService;
use ZF\ApiProblem\ApiProblem;

class FiliaisService extends AbstractService
{

    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = 'crm\Entity\Filiais';
    }

    public function getByNome($nome)
    {
        $filial = $this->em->getRepository($this->repository)->findBy(array('nomeFantasia'=>$nome));

        if(isset($filial[0])) {
           return $filial[0];
        }

        return null;
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT f.id, f.razaoSocial FROM '.$this->repository.' f where f.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recursos nãoo localizados");
    }



}