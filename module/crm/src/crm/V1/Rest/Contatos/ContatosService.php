<?php

namespace crm\V1\Rest\Contatos;


use crm\Entity\ContatosOrigem;
use crm\Entity\EmailsContato;
use crm\Entity\TelefonesContato;
use crm\V1\Rest\AbstractService\AbstractService;
use crm\V1\Rest\Interacoes\InteracoesFactory;
use crm\V1\Rest\SituacoesContato\SituacoesContatoEntity;


class ContatosService extends AbstractService
{
    /**
     * De acordo com o tipo da origem retornado da box
     * consulta no repository de cada tipo de maneira din�mica;
     * @var array
     */
    protected $tiposOrigens;

    /**
     * @var \crm\Entity\Contatos
     */
    protected $contatoEntity;

    /**
     * @var \crm\V1\Rest\Contatos\ContatosFactory
     */
    protected $contatoFactory;

    /**
     * @var \crm\V1\Rest\Interacoes\InteracoesFactory
     */
    protected $interacoesFactory;

    public function __construct($em, $hydrator,$contatoEntity,  ContatosFactory $contatoFactory, InteracoesFactory $interacoesFactory)
    {
        $this->em            = $em;
        $this->hydrator      = $hydrator;
        $this->contatoEntity = $contatoEntity;
        $this->contatoFactory          = $contatoFactory;
        $this->interacoesFactory       = $interacoesFactory;
        $this->repository              = 'crm\Entity\Contatos';
    }

    public function create($data)
    {
        $novoContato = $this->contatoFactory->create($data);
        $this->em->persist($novoContato);


        //Separar em factories
        foreach($data->telefones as $telefone) {
            $novoTelefone = new TelefonesContato();
            $this->hydrate($novoTelefone,$telefone);
            $this->em->persist($novoTelefone);
            $novoTelefone->setContato($novoContato);
            $novoTelefone->setDataCriacao();
        }

        //Separar em factories
        if(isset($data->emails) && count($data->emails) > 0) {
            foreach($data->emails as $email) {
                $novoEmail = new EmailsContato();
                $this->hydrate($novoEmail,$email);
                $this->em->persist($novoEmail);
                $novoEmail->setContato($novoContato);
                $novoEmail->setDataCriacao();
            }
        }

        $interacoes       = $this->interacoesFactory->create($data, $novoContato);
        $this->em->persist($interacoes);



        try {
            $this->em->flush();
            return $this->retornaContatoInteracao($interacoes, $novoContato);

        } catch (Exception $e) {
            die(var_dump($e->getMessage()));
        }

        return false;
    }

    public function retornaContatoInteracao($interacao, $contato)
    {
        $data = [];
        $data['interacao'] = $this->extract($interacao);
        $data['contato']   = $this->extract($contato);
        return $data;
    }

    public function fetchAll()
    {
        return $this->em->getRepository("crm\Entity\Contatos")->getContatosEnvio();
    }

    public function getById($id)
    {
        return $this->em->getRepository("crm\Entity\Contatos")->getById($id);
    }

    public function getByNome($parametros)
    {

        $qb = $this->em->createQueryBuilder();
        $qb->select('c')
            ->from('crm\Entity\Contatos', 'c')
            ->where("c.nome LIKE :nome")
            ->andWhere("c.status = 0")
            ->orderBy('c.id', 'ASC')
            ->setParameter('nome', '%'.$parametros->termo.'%');

       return $qb->getQuery()->getArrayResult();

    }

    public function getByEmail($parametros)
    {
        $sql =
            "SELECT
                contato.id as id,
                contato.nome,
                contato.idade,
                contato.observacao,
                contato.empresa,
                contato.numeroPessoasEmpresas,
                contato.interesse,
                contato.dataCriacao,
                emailsContato.email
             FROM
               crm\Entity\EmailsContato emailsContato
             JOIN
               emailsContato.contato as contato
             WITH
               emailsContato.contato = contato.id
             WHERE
              emailsContato.email = :email
            ";

        $parameters = array(
            'email'  => $parametros->termo
        );

        $query = $this->em->createQuery($sql);
        $query->setParameters( $parameters );
        $result = $query->getResult();

        if(!empty($result)) {
            return ($result);
        }
        return false;

    }

    public function getByFone($parametros)
    {
        $sql =
            "SELECT
                contato.id as id,
                contato.nome,
                contato.idade,
                contato.observacao,
                contato.numeroPessoasEmpresas,
                contato.dataCriacao,
                telefonesContato.telefone
             FROM
               crm\Entity\TelefonesContato telefonesContato
             JOIN
               telefonesContato.contato as contato
             WITH
               telefonesContato.contato = contato.id
             WHERE
              telefonesContato.telefone = :telefone
            ";

        $parameters = array(
            'telefone'  => $parametros->termo
        );

        $query = $this->em->createQuery($sql);
        $query->setParameters( $parameters );
        $result = $query->getResult();

        if(!empty($result)) {
            return ($result);
        }
        return false;

    }

    public function getRelatorioLigacoes($parametros)
    {
        return $this->em->getRepository('crm\Entity\Contatos')->getRelatorioLigacoes($parametros);
    }

    public function getReferenceContato($id)
    {
        return $this->em->getReference('crm\Entity\Contatos', $id);
    }

}