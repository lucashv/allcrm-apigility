<?php

namespace crm\V1\Rest\Corretores;


use crm\V1\Rest\AbstractService\AbstractService;
use ZF\ApiProblem\ApiProblem;

class CorretoresService extends AbstractService
{


    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param $hydrator
     * @param $corretorEntity
     */
    public function __construct($em,$hydrator, $corretorEntity)
    {
        $this->em         = $em;
        $this->hydrator   = $hydrator;
        $this->corretorEntity = $corretorEntity;
        $this->repository = 'crm\Entity\Usuarios';
    }

    public function fetchAll()
    {

            //Perfil 2 == CORRETOR
            //Perfil 9 == Cordernador comercial Filial
            // Perfil 12 == Assistente de vendas
            $query = $this->em->createQuery('
                                           SELECT
                                            u.nome,
                                            u.sobreNome,
                                            u.email,
                                            u.id,
                                            u.envioBloqueado,
                                            filiais.razaoSocial as filialCorretor,
                                            filiais.id as idFilial
                                          FROM '.$this->repository.' u
                                          JOIN crm\Entity\Filiais filiais WITH filiais.id = u.filial
                                          where
                                           u.perfil IN (2,9, 12)
                                          AND
                                           u.status = TRUE ORDER BY u.nome');
            $results = $query->getResult();

            if(!is_null($results)) {
                return  $results;
            }
            return new ApiProblem('404', "Recurso não localizado");
    }

    public function getByParameter($parameters)
    {

        if( $parameters->tipo == 'todos') {
            return $this->fetchAll();
        }

        if ( $parameters->tipo == "nome" )
        {
            $corretores =  $this->getByNome($parameters->termo);
            return $corretores;
        }

        if($parameters->tipo == "filial")
        {
            return $this->em->getRepository($this->repository)->getCorretorPorFilial($parameters->filialId);
        }

        return false;
    }

    public function getByNome($nome)
    {

        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from('crm\Entity\Usuarios', 'u')
            ->where("u.nome LIKE :nome")
            ->andWhere("u.status = :status")
            ->orderBy('u.id', 'ASC')
            ->setParameter('nome', '%'.$nome.'%')
            ->setParameter('status', 1);

        $corretores =  $qb->getQuery()->getArrayResult();
        if($corretores) {
            return $corretores;
        }

        return false;

    }



}