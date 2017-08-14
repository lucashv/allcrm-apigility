<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 10/03/2016
 * Time: 10:50
 */

namespace crm\V1\Rest\AtualizaTipoEnvioPai;


use crm\V1\Rest\Cron\CronInterface;
use ZF\ApiProblem\ApiProblem;

class AtualizaTipoEnvioPai implements CronInterface
{
    protected $em;

    protected $con;

    public function  __construct($em)
    {
        $this->em = $em;
        $this->con = $this->em->getConnection();
    }


    public function execute()
    {
        $indicacoes = $this->getTipoEnvioPai();
        $atualizado = $this->atualizaPai($indicacoes);

        if( !empty($atualizado) ) {
            return $atualizado;
        }
        return new ApiProblem(404, 'Sem interações pai faltando tipo Envio');
    }


    private function getTipoEnvioPai()
    {
        $sql = "SELECT
                  id,
                  `interacao_pai_id`,
                  `tipo_envio_id`,
                  `contato_id`
                FROM
                  `interacoes_contato`
                WHERE `situacao_interecoes_id` = 2
                  AND `tipo_envio_id` IS NULL
                  AND `interacao_pai_id` IS NULL
                GROUP BY `contato_id` ";

        $stmt = $this->con->prepare($sql);

        $stmt->execute();
        return  $stmt->fetchAll();
    }

    private function atualizaPai($indicacoes)
    {

        $atualizados = [];

        foreach($indicacoes as $indicacao) {
            $atualizados[] = $indicacao;

                $interacaoPai = $this->em->getReference('crm\Entity\InteracoesContato', $indicacao['interacao_pai_id']);
                $tipoEnvio = $this->em->getReference('crm\Entity\TiposEnvio', $indicacao['tipo_envio_id']);
                $interacaoPai->setTipoEnvio($tipoEnvio);
                $this->em->persist($interacaoPai);
                $this->em->flush();
        }
        return $atualizados;

    }

}