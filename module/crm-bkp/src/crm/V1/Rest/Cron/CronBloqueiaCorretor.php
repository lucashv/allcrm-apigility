<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 07/03/2016
 * Time: 12:06
 */

namespace crm\V1\Rest\Cron;

set_time_limit(0);
use crm\V1\Rest\Logger\Logger;
use ZF\ApiProblem\ApiProblem;
use crm\V1\Rest\ContatoCorretorBloqueio\ContatoCorretorBloqueioService;
use Zend\Log\Logger as ZendLoger;
use Zend\Log\Writer\Stream;

class CronBloqueiaCorretor extends \Doctrine\ORM\EntityRepository implements CronInterface
{

    protected $connection;
    protected $idOrigensIgnoradas = "155,
                                     120"; // Ligação plantao , Indicação Própria.
    protected $logger;

    protected $contatoCorretorBloqueioService;

    protected $nomeArquivoLog;

    protected $hoje;

    protected  $write;


    public function __construct($em, $logger, ContatoCorretorBloqueioService $contatoBloqueioService)
    {
        $this->em = $em;
        $this->connection = $em->getConnection();
        $this->logger = new Logger();
        $this->contatoCorretorBloqueioService = $contatoBloqueioService;
        $this->hoje = date('d/m/Y H:i:s');
        $this->nomeArquivoLog = 'bloqueioDeCorretores.log';
    }

    public function execute()
    {
        $interacoes = $this->getIndicacoesPendentes24Horas();
        $this->gravaBloqueio($interacoes);
        $this->logger->log('crons.log', " BloqueioDeCorretores - CRON EXECUTADO COM SUCESSO EM: {$this->hoje} ");
        return $interacoes;
    }

    private function getIndicacoesPendentes24Horas()
    {
        $sql = "SELECT
                      ic.id,
                      ic.`situacao_interecoes_id`,
                      ic.`data_criacao`,
                      TIMEDIFF(NOW(), ic.data_criacao) AS tempoEmAtraso,
                      c.id AS idContato,
                      ic.`usuario_id` AS usarioCadastro,
                      corretor.id AS corretorId,
                      CONCAT(corretor.nome, ' ', corretor.sobre_nome) as corretor,
                      ic.`interacao_pai_id`
                    FROM
                      `interacoes_contato` AS ic
                      JOIN `contatos` AS c
                        ON c.id = ic.`contato_id`
                      JOIN usuarios as corretor
                        ON ic.corretor_usuario_id = corretor.id
                    WHERE ic.`interacao_pai_id` IS NULL
                      AND ic.`usuario_id` <> ic.`corretor_usuario_id`
                      AND TIMEDIFF(NOW(), ic.data_edicao) > '24:00:00'
                      AND ic.`situacao_interecoes_id` = 2
                      AND c.`status` = TRUE
                      AND ic.interacoes_origem_id NOT IN ({$this->idOrigensIgnoradas})
                      ";

        $stmt = $this->connection->prepare($sql);


        try {
            $stmt->execute();
            $indicacoes =  $stmt->fetchAll();


            if(empty($indicacoes)) {
                return new ApiProblem(404, "Sem indicações em atraso de resposta");
            }
            return $indicacoes;

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

    }

    private function gravaBloqueio($indicacoes)
    {

        foreach($indicacoes as $indicao)
        {
                $data['corretorId']    =   isset($indicao['corretorId']) ? $indicao['corretorId'] : false;
                $data['contato']       =   isset($indicao['idContato']) ? $indicao['idContato'] : false;
                $data['tempoEmAtraso'] =   isset($indicao['tempoEmAtraso']) ? $indicao['tempoEmAtraso'] : false;
                $data['corretorNome']  =   isset($indicao['corretor']) ? $indicao['corretor'] : false;
                $this->contatoCorretorBloqueioService->create($data);
                $retornoLog = $this->gravaLogBloqueio($data);
                if($retornoLog){
                    unset($data);
                }
        }
    }

    private  function gravaLogBloqueio($log)
    {
        $logger = new ZendLoger();
        $this->write = new Stream('./../logs/'.$this->nomeArquivoLog);
        $logger->addWriter($this->write);
        $logger->log(\Zend\Log\Logger::INFO,"Corretor Bloqueado: {$log['corretorNome']} ({$log['corretorId']}) Em : $this->hoje - Contato Pendente : {$log['contato']} - Tempo Em Atraso : {$log['tempoEmAtraso']}  ");
        return true;
    }



}