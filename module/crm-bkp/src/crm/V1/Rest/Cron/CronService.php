<?php

namespace crm\V1\Rest\Cron;


use crm\V1\Rest\AbstractService\AbstractService;
use ZF\ApiProblem\ApiProblem;
use crm\V1\Rest\AtualizaTipoEnvioPai\AtualizaTipoEnvioPai;

class CronService extends  AbstractService
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    protected $logger;

    protected $contatoCorretorBloqueioService;

    public function __construct($em, $loger, $contatoCorretorBloqueioService)
    {
        $this->em = $em;
        $this->logger = $loger;
        $this->contatoCorretorBloqueioService = $contatoCorretorBloqueioService;
    }

    public function executaCron($parametros)
    {

        if($parametros->cron === '') {
            return new ApiProblem(404, 'Informe o Cron a ser executado');
        }

        if($parametros->cron === 'bloqueiaCorretor') {
            $cron = new CronBloqueiaCorretor($this->em, $this->logger, $this->contatoCorretorBloqueioService);
        }

        if($parametros->cron === 'atualizaTipoEnvioPai') {
            $cron = new AtualizaTipoEnvioPai($this->em);
        }
            if(!isset($cron)) {
                return new ApiProblem(404, 'Cron não parametrizado');
            }

            $retornoTarefa = $cron->execute();


            return $retornoTarefa;



    }

}