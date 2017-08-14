<?php

namespace crm\V1\Rest\Interacoes;


use crm\Entity\ContatoCorretorBloqueio;
use crm\Entity\SituacaoProposta;
use crm\V1\Rest\Email\EmailService;
use crm\Entity\InteracoesContato;
use crm\V1\Rest\AbstractService\AbstractService;
use crm\V1\Rest\Contatos\ContatosService;
use ZF\ApiProblem\ApiProblem;
use crm\V1\Rest\OrigensInteracoes\OrigensInteracoesService;

class InteracoesService extends AbstractService
{

    protected $situacoesInteracoesService;

    /**
     * @va \OrigensInteracoes\OrigensInteracoesService
     */
    protected $origemInteracoesService;
    protected $usuarioService;
    protected $contatoService;
    protected $emailService;

    public function __construct($em, $hydrator, InteracoesContato $interacoesEntity, $situacoesInteracoesService, OrigensInteracoesService $origemInteracoesService, ContatosService $contatoService ,$usuarioService, EmailService $emailService)
    {
        $this->em                         = $em;
        $this->hydrator                   = $hydrator;
        $this->entity                     = $interacoesEntity;
        $this->situacoesInteracoesService = $situacoesInteracoesService;
        $this->origemInteracoesService    = $origemInteracoesService;
        $this->contatoService             = $contatoService;
        $this->usuarioService             = $usuarioService;
        $this->repository                 = 'crm\Entity\InteracoesContato';
        $this->emailService               = $emailService;

    }

    public function create($data)
    {

        $interacao        = new $this->entity;
        $this->em->persist($interacao);
        $interacaoPai     = $this->getById($data->idInteracaoPai);

        $contato          = $this->contatoService->getReferenceContato( $data->idContato );

        if( isset($data->idTipoEnvio) ) {
            $tipoEnvio        = $this->em->find('crm\Entity\TiposEnvio', $data->idTipoEnvio);
            $interacao->setTipoEnvio( $tipoEnvio );
        }

        $contatoBloqueouCorretor = $this->em->getRepository('crm\Entity\ContatoCorretorBloqueio')->findByContatoCorretor($data->idContato, $data->idCorretor );

        if(!empty($contatoBloqueouCorretor)) {
            $contatoBloqueouCorretor = $this->hydrate(new ContatoCorretorBloqueio(), $contatoBloqueouCorretor[0]);
            $contatoBloqueouCorretor->setStatus(0)
                                    ->setDataDesbloqueio(new \DateTime("now"));
            $this->em->persist($contatoBloqueouCorretor);
        }


        if( isset($data->obsTipoEnvio)) {
            $interacao->setObservacaoEnvio($data->obsTipoEnvio);
        }
        //TODO abstrair na factory
        $interacao->setInteracaoPai( $interacaoPai )
                  ->setDescricao($data->observacao)
                  ->setContato( $contato )
                  ->setDataCriacao( )
                  ->setUsuario( $this->usuarioService->getById( $data->idUsuarioCad ) )
                  ->setCorretor( $this->usuarioService->getById($data->idCorretor) )
                  ->setSituacoesInteracoes( $this->situacoesInteracoesService->getSituacaoInteracao( $data->situacao ) )
                  ->setInteracoesOrigem( $this->origemInteracoesService->getById( $data->idOrigem) );

        if(isset($data->plantao)){
            $interacao->setPlantao($this->getPlantao($data->plantao));
        }



        $tipoEnvio =   isset($tipoEnvio) ? $tipoEnvio : false;
        $atualizaPai = $this->atualizaPai( $data->idInteracaoPai, $data->situacao, $data->idCorretor, $tipoEnvio);

        if(!$atualizaPai) {
            return new ApiProblem(500, 'Erro ao atualizar interação pai');
        }



        if($data->enviarEmail)
        {

            if( $this->emailService->enviaIndicacao( $interacao ) )
            {
                $interacao->setEmailEnviado( 1 );
                $this->em->flush();
                return $this->extract( $interacao );
            } else {
                $interacao->setEmailEnviado( 0 );
                $this->em->flush();
                return $this->extract( $interacao );
            }
        } else {
            $interacao->setEmailEnviado( 0 );
            $this->em->flush();
            return $this->extract( $interacao );
        }

        return new ApiProblem(420, "Erros");


    }

    public function getById($id)
    {
        return $this->em->getReference($this->repository, $id);
    }

    private function atualizaPai($idPai, $idSituacao, $idCorretor, $tipoEnvio = false)
    {
        $entidadePai = $this->em->find('crm\Entity\InteracoesContato', $idPai);


        if(isset($tipoEnvio)) {
            $tipoEnvio = $this->em->find('crm\Entity\TiposEnvio', $tipoEnvio);
            $entidadePai->setTipoEnvio($tipoEnvio);
        }

        $entidadePai->setSituacoesInteracoes( $this->situacoesInteracoesService->getSituacaoInteracao( $idSituacao ) );
        $entidadePai->setCorretor( $this->usuarioService->getById($idCorretor) );
        $entidadePai->setDataEdicao(new \DateTime("now"));


        try {
            $this->em->persist($entidadePai);
            $this->em->flush();
            return true;
        } catch (Exception $e) {
            die(var_dump($e->getMessage()));
        }
    }

    public function getIndicacoesCorretor($idCorretor,$interacaoId = false)
    {
        $sql =
            "SELECT DISTINCT
                contato.id as contatoId,
                contato.nome,
                contato.idade,
                contato.observacao,
                contato.empresa,
                contato.numeroPessoasEmpresas,
                contato.interesse,
                situacao.descricao as situcaoContato,
                situacao.id as situacaoId,
                situacao.id as idSituacao,
                CONCAT( usuario.nome,' ',usuario.sobreNome) as usuarioCadastro,
                usuario.id as idUsuarioCadastro,
                origem.origem,
                emailsContato.email,
                interacoesContato.id as idInteracaoContatoId,
                telefonesContato.telefone,
                sites.site,
                fornecedores.razaoSocial razaoSocialFornecedor,
                outrasOrigens.outraOrigem tipoOutraOrigem,
                origem.id as idOrigem
            FROM
                crm\Entity\InteracoesContato interacoesContato
                LEFT JOIN interacoesContato.usuario as usuario
                LEFT JOIN interacoesContato.contato as contato
                LEFT JOIN interacoesContato.situacoesInteracoes as situacao
                LEFT JOIN interacoesContato.interacoesOrigem as origem
                LEFT JOIN crm\Entity\EmailsContato emailsContato WITH emailsContato.contato = contato.id
                LEFT JOIN crm\Entity\TelefonesContato telefonesContato WITH telefonesContato.contato = contato.id
                LEFT JOIN crm\Entity\Sites sites WITH sites.id = origem.sites
                LEFT JOIN crm\Entity\Fornecedores fornecedores WITH fornecedores.id = origem.fornecedor
                LEFT JOIN crm\Entity\OutrasOrigensInteracoes outrasOrigens WITH outrasOrigens.id = origem.outrasOrigensInteracoes
                LEFT JOIN crm\Entity\TiposEnvios tipoEnvio WITH tipoEnvio.id = interacoesContato.tipo_envio_id
              WHERE
               interacoesContato.corretor = :idCorretor";

        if($interacaoId) {
            $sql .=" \nAND
                      interacoesContato = :interacaoId";
            $parameters = array(
                'idCorretor'  => $idCorretor,
                'interacaoId' => $interacaoId
            );

        } else {
            $parameters = array(
                'idCorretor'  => $idCorretor
            );
        }
        $sql .= " \nORDER BY tipoEnvio.id DESC GROUP BY contato.id";


        $query = $this->em->createQuery($sql);
        $query->setParameters( $parameters );

        return $query->getResult();
    }

    public function getInteracoesContato($idContato)
    {
        $entity['interacoes'] =  $this->em->getRepository('crm\Entity\InteracoesContato')->findByContato($idContato);


        if(!empty($entity)) {
            return $this->padronizaRetorno($entity);
        }
        return false;
    }

    private function getPlantao($plantao)
    {
        return $this->em->getReference('crm\Entity\Plantoes', $plantao['id']);
    }

    // Monta o objeto para retornar corretamente para o App.
    public function padronizaRetorno ($result)
    {
        $interacoes = array();

        foreach($result['interacoes'] as $interacao)
        {
            //die(var_dump($interacao->getDataCriacao()->format('d-m-Y H:i:s')));

            $interacoes[] = array(

                'contatoId'  => $interacao->getContato()->getId(),
                'nome'       => $interacao->getContato()->getNome(),
                'idade'      => $interacao->getContato()->getIdade(),
                'observacao' => $interacao->getContato()->getObservacao(),
                'descricaoInteracao' => $interacao->getDescricao(),
                'empresa'    => $interacao->getContato()->getEmpresa(),
                'operadora'  => $interacao->getContato()->getOperadora(),
                'numeroPessoasEmpresas'    => $interacao->getContato()->getNumeroPessoasEmpresas(),
                'interesse'              => $interacao->getContato()->getInteresse(),
                'situcao'                => $interacao->getSituacoesInteracoes()->getDescricao(),
                'situcaoObj'             => $interacao->getSituacoesInteracoes(),
                'idSituacao'             => $interacao->getSituacoesInteracoes()->getId(),
                'origemDesc'             => $interacao->getInteracoesOrigem()->getOrigem(),
                'origemId'               => $interacao->getInteracoesOrigem()->getId(),
                'usuarioCadastro'        => $interacao->getUsuario()->getNome().' '.$interacao->getUsuario()->getSobreNome(),
                'idUsuarioCadastro'      => $interacao->getUsuario()->getId(),
                'origem'                 => $interacao->getInteracoesOrigem()->getOrigem(),
                'idOrigem'               => $interacao->getInteracoesOrigem()->getId(),
                'idInteracoesContato'    => $interacao->getId(),
                'idInteracaoPai'         => ($interacao->getInteracaoPai()) ? $interacao->getInteracaoPai()->getId() : null ,
                'dataCadastro'           =>  $interacao->getDataCriacao()->format('d-m-Y H:i:s'),
                'site'                   => ($interacao->getInteracoesOrigem()->getSites()) ? $interacao->getInteracoesOrigem()->getSites()->getSite() : null,
                'razaoSocialFornecedor'  => ($interacao->getInteracoesOrigem()->getFornecedor()) ? $interacao->getInteracoesOrigem()->getFornecedor()->getRazaoSocial() : null,
                'tipoOutraOrigem'        => ($interacao->getInteracoesOrigem()->getOutrasOrigensInteracoes()) ? $interacao->getInteracoesOrigem()->getOutrasOrigensInteracoes()->getOutraOrigem()  : null,
                'corretorId'             => ($interacao->getCorretor())     ? $interacao->getCorretor()->getId(): null,
                'corretorNome'           => ($interacao->getCorretor())     ? $interacao->getCorretor()->getNome(): null,
                'corretorSobreNome'      => ($interacao->getCorretor())     ? $interacao->getCorretor()->getSobreNome(): null,
                'dataEdicao'             => ($interacao->getDataEdicao())   ? $interacao->getDataEdicao()->format('d-m-Y H:i:s'): null,
                'emailEnviado'           => $interacao->isEmailEnviado(),
                'idTipoEnvio'            => ($interacao->getTipoEnvio())   ? $interacao->getTipoEnvio()->getId() : null

            );

        }

        return $interacoes;

    }

    public function fetch($params)
    {
        if($params->tipo === 'relatorioIndicacoes') {
            return $this->em->getRepository($this->repository)->getRelatorioIndicacoes($params);
        }

        if($params->tipo === 'relatorioGeral') {

            return $this->em->getRepository($this->repository)->relatorioGeral($params);
        }

        if(!$params->corretorId && !$params->idContato) {
            return new ApiProblem(403, 'Informe o corretor, o contato ou a interac�o!');
        }

        if($params->idContato) {
            return $this->getInteracoesContato($params->idContato);
        }
        if($params->corretorId && $params->interacaoId) {
            return $this->getIndicacoesCorretor($params->corretorId ,$params->interacaoId);
        }
        return $this->getIndicacoesCorretor( $params->corretorId );

    }
}
