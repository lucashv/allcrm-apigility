<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 08/10/2015
 * Time: 15:35
 */

namespace crm\V1\Rest\OrigensInteracoes;

use crm\Entity\OutrasOrigensInteracoes;
use crm\V1\Rest\AbstractService\AbstractService;

class OrigensInteracoesService extends AbstractService
{
    protected $fornecedorEntity;

    protected $tiposOrigens = array();

    public function __construct($em,$hydrator)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->fornecedorEntity;
        $this->repository = 'crm\Entity\InteracoesOrigem';
        $this->tiposOrigens  =  array(
            'sites'        => array(
                'repository' => 'crm\Entity\Sites',
                'id'         => 'id_sites',
                'entidade'   => 'sites'
            ),
            'fornecedores' => array(
                'repository'  => 'crm\Entity\Fornecedores',
                'id'          => 'id_fornecedores',
                'entidade'   =>  'fornecedor'
            ),
            'outras'       => array(
                'repository'   => 'crm\Entity\OutrasOrigensInteracoes',
                'id'           => 'outras_origens_interacoes_id',
                'entidade'     => 'OutrasOrigensInteracoes'
            )
        );
    }


    public function fetchAllOutrasOrigens()
    {
        $query = $this->em->createQuery
        ('
          SELECT
          f.id, f.outraOrigem, f.dataCriacao
          FROM crm\Entity\OutrasOrigensInteracoes f
          where f.status = 1
        ');
        $results = $query->getResult();
        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

    public function getById($id)
    {
       return $this->em->getReference($this->repository, $id);
    }

    public function getOrigemInteracoes($data)
    {

        // Consulta o Site/Fornecedor/OutasOrigens
        $origem = $this->em->getReference($this->tiposOrigens[$data->origemTipo]['repository'], $data->origem['id']);

        // Consulta na tabela interacoes_origens o id
        $query = $this->em->createQuery(
            'SELECT o.id, o.origem
             FROM '.$this->repositoryOrigens.' o
             WHERE o.'.$this->tiposOrigens[$data->origemTipo]['entidade'].'='.$origem->getId() );
        $result = $query->getResult();

        if(empty($result)) {
            die('404 Origen não cadastrada na base');
        }

        $origemEntity =  $this->em->getReference($this->repositoryOrigens, $result[0]['id']);
        $origemEntity->setOrigem( $result[0]['origem']);
        return $origemEntity;
    }

}