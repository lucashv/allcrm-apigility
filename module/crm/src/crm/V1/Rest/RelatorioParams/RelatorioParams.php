<?php
namespace crm\V1\Rest\RelatorioParams;

interface RelatorioParams
{

    public function getDataInicio();

    public function setDataInicio($dataInicio);

    public function getDataFim();

    public function setDataFim($dataFim);

    public function getInativos();

    public function setInativos($inativos);

}