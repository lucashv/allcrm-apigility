<?php

namespace crm\V1\Rest\GestoNacionalDashBoard;


use crm\V1\Rest\AbstractService\AbstractService;


class GestorNacionalDashBoardService extends AbstractService
{
    protected $em;

    public function __construct($em)
    {

        $this->em = $em;
    }

    public function getDadosDashBoard($parametros)
    {
        $dados = $this->em->getRepository('crm\Entity\InteracoesContato')->relatorioGeral($parametros);

        return $this->montaArrayGestorNascional($dados);
    }

    private function montaArrayGestorNascional($dados)
    {
        $filiais = [];



        $ultimoIndice = count($dados) - 1;
        unset($dados[$ultimoIndice]);

        foreach($dados as $indicacao) {

                if(isset($indicacao['nomeFilialCorretor']) &&  !array_key_exists($indicacao['nomeFilialCorretor'], $filiais)){
                    $filiais[$indicacao['nomeFilialCorretor']]   = array();
                    array_push($filiais[$indicacao['nomeFilialCorretor']], $indicacao);
                } else {
                    array_push($filiais[$indicacao['nomeFilialCorretor']], $indicacao);
                }


        }
        return $filiais;

    }

}