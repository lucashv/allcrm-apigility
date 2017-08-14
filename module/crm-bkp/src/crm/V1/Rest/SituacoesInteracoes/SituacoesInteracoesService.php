<?php

namespace crm\V1\Rest\SituacoesInteracoes;


use crm\Entity\SituacoesInteracoes;
use crm\V1\Rest\AbstractService\AbstractService;

class SituacoesInteracoesService extends AbstractService
{
    protected $situacoesEntity;

    public function __construct($em,$hydrator, SituacoesInteracoes $situacoesEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->situacoesEntity = $situacoesEntity;
        $this->repository = 'crm\Entity\SituacoesInteracoes';
    }

    public function fetchAll()
    {
        $query = $this->em->createQuery
        ('
          SELECT
          f.id, f.descricao, f.dataCriacao, f.statusPai
          FROM '.$this->repository.' f
          where f.status = 1
        ');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

    public function getSituacaoInteracao($id)
    {
        return  $this->em->getReference('crm\Entity\SituacoesInteracoes',$id);
    }



}