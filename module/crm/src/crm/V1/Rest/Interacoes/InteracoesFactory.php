<?php

namespace crm\V1\Rest\Interacoes;


use crm\Entity\InteracoesContato;
use crm\V1\Rest\AbstractService\AbstractService;

class InteracoesFactory extends AbstractService
{
    protected $interacoesContatoEntity;
    protected $em;
    protected $hydrator;
    protected $sm;

    public function __construct($em, $hydrator, $sm, InteracoesContato $interacoesContato)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->sm = $sm;
        $this->interacoesContatoEntity = $interacoesContato;
        $this->repositoryOrigens       = 'crm\Entity\InteracoesOrigem';
        $this->tiposOrigens  =  array(
            'sites'        => array(
                'repository' => 'crm\Entity\Sites',
                'id'         => 'id_sites',
                'entidade'   => 'sites'
            ),
            'fornecedores' => array(
                'repository'  => 'crm\Entity\Fornecedores',
                'id'          => 'id_fornecedores',
                'entidade'    =>  'fornecedor'
            ),
            'outras'       => array(
                'repository'   => 'crm\Entity\OutrasOrigensInteracoes',
                'id'           => 'outras_origens_interacoes_id',
                'entidade'     => 'outrasOrigensInteracoes'
            )
        );

    }

    public function create($data, $contatoEntity)
    {

        $this->interacoesContatoEntity->setDescricao("Contato cadastrado no sistema.")
                                      ->setContato($contatoEntity)
                                      ->setDataCriacao()
                                      ->setUsuario($this->em->getReference('crm\Entity\Usuarios', $data->idUsuarioCad))
                                      ->setSituacoesInteracoes($this->getSituacaoInteracao($data))
                                      ->setInteracoesOrigem($this->getOrigemInteracoes($data));

        if(isset($data->plantao)){
            $this->interacoesContatoEntity->setPlantao($this->getPlantao($data->plantao));
        }


        return $this->interacoesContatoEntity;

    }

    private function getSituacaoInteracao($data)
    {
        return $this->em->getReference('crm\Entity\SituacoesInteracoes', $data->situacao);
    }

    private function getOrigemInteracoes($data)
    {

        // Consulta o Site/Fornecedor/OutasOrigens
        $origem = $this->em->getReference($this->tiposOrigens[$data->origemTipo]['repository'], $data->origem['id']);

        // Consulta na tabela interacoes_origens o id
        $query = $this->em->createQuery(
            'SELECT o.id, o.origem
             FROM ' . $this->repositoryOrigens . ' o
             WHERE o.' . $this->tiposOrigens[$data->origemTipo]['entidade'] . '=' . $origem->getId());
        $result = $query->getResult();

        if (empty($result)) {
            throw new \InvalidArgumentException('O id informada não corresponde a uma origem válida');
        }

        $origemEntity = $this->em->getReference($this->repositoryOrigens, $result[0]['id']);
        $origemEntity->setOrigem($result[0]['origem']);
        return $origemEntity;

    }

    private function getPlantao($plantao)
    {
        return $this->em->getReference('crm\Entity\Plantoes', $plantao['id']);
    }


}