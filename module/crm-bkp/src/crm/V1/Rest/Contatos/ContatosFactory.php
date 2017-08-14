<?php

namespace crm\V1\Rest\Contatos;


use crm\Entity\Contatos;
use crm\V1\Rest\AbstractService\AbstractService;

class ContatosFactory extends AbstractService
{
    protected $contatoEntity;
    protected $em;
    protected $hydrator;
    protected $sm;

    public function __construct($em, $hydrator, $sm, Contatos $contatoEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->sm = $sm;
        $this->contatoEntity = $contatoEntity;
    }

    public function create($data)
    {
        $this->contatoEntity = $this->montaUsuarioEntity($data);

        $this->contatoEntity->setDataCriacao();


        if(isset($data->idOperadora)) {
            $this->contatoEntity->setOperadora($this->em->getReference('crm\Entity\Operadoras' , $data->idOperadora ));
        }



        return $this->contatoEntity;

    }

    private function montaUsuarioEntity ($data)
    {
        $novoContato =  array(
            'nome'       => $data->nome,
            'idade'      => isset($data->idade) ? $data->idade : 0,
            'observacao' => isset($data->observacao)? $data->observacao       : NULL ,
            'empresa'    => isset($data->empresa)   ? $data->empresa          : NULL ,
            'numeroPessoasEmpresas' => isset($data->numeroPessoas) ? $data->numeroPessoas    : 0,
            'servico'     => isset($data->servico)  ? $data->servico              : NULL,
            'status'      => 1,
            'enviarPara' => isset($data->enviarPara) ? $data->enviarPara    : 'Saúde',
        );
        return $this->hydrate($this->contatoEntity, $novoContato);
    }


}