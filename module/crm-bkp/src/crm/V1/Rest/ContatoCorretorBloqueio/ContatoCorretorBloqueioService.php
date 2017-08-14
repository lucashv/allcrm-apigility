<?php

namespace crm\V1\Rest\ContatoCorretorBloqueio;


use crm\V1\Rest\AbstractService\AbstractService;

class ContatoCorretorBloqueioService extends AbstractService
{
    protected $contatoBloqueioFactory;

    public function __construct($em,ContatoBloqueioFactory $contatoBloqueioFactory )
    {
        $this->em = $em;
        $this->contatoBloqueioFactory = $contatoBloqueioFactory;
        $this->repository = 'crm\Entity\ContatoCorretorBloqueio';
    }

    public function create($data)
    {
            $contatoCorretorBloqueio = $this->contatoBloqueioFactory->create($data);
            $this->em->persist($contatoCorretorBloqueio);
            $this->em->flush();
            return $contatoCorretorBloqueio;
    }

    public function fetchAll()
    {
    //  JOIN crm\Entity\Filiais filiais WITH filiais.id = u.filial
      $query = $this->em->createQuery("
                                    SELECT
                                     ccb.id,
                                     usr.nome corretor,
                                     con.nome contato ,
                                     ccb.dataBloqueio,
                                     ccb.status
                                     FROM
                                      {$this->repository} ccb
                                      JOIN crm\Entity\Usuarios usr WITH ccb.corretor = usr.id
                                      JOIN crm\Entity\Contatos con WITH ccb.contato = con.id"
                                    );
      $results = $query->getResult();
      if(!is_null($results)) {
          return  $results;
      }
      return new ApiProblem('404', "Recurso n�o localizado");
    }

    public function getById($id)
    {

      $query = $this->em->createQuery("
                                    SELECT
                                     ccb.id,
                                     usr.nome corretor,
                                     con.nome contato ,
                                     ccb.dataBloqueio,
                                     ccb.status
                                     FROM
                                      {$this->repository} ccb
                                      JOIN crm\Entity\Usuarios usr WITH ccb.corretor = usr.id
                                      JOIN crm\Entity\Contatos con WITH ccb.contato = con.id
                                      WHERE
                                      usr.id = {$id}
                                      AND
                                      ccb.status = 1"
                                    );
      $results = $query->getResult();
      if(!is_null($results)) {
          return  $results;
      }
      return new ApiProblem('404', "Recurso não localizado");
    }

    public function fetchByParams($params) {

        if($params->tipo === 'byContato') {
            return $this->em->getRepository($this->repository)->findByContato($params->idContato);
        }
    }
}
