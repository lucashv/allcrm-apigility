<?php


namespace crm\V1\Rest\AgendaUsuario;
use  crm\V1\Rest\RelatorioParams\RelatorioParams;

class AgendaUsuarioRelatorio implements RelatorioParams
{
    public $dataInicio;
    public $dataFim;
    public $inativos;
    public $concluidos;
    public $idUsuario;

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     * @return AgendaUsuarioRelatorio
     */
    public function setDataInicio($dataInicio = false)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     * @return AgendaUsuarioRelatorio
     */
    public function setDataFim($dataFim = false)
    {
        $this->dataFim = $dataFim;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInativos()
    {
        return $this->inativos;
    }

    /**
     * @param mixed $inativos
     * @return AgendaUsuarioRelatorio
     */
    public function setInativos($inativos = false)
    {

        if(empty($inativos) || $inativos == 'false'){
            $this->inativos = (bool) false;
            return $this;
        }
        $this->inativos = $inativos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConcluidos()
    {
        return $this->concluidos;
    }

    /**
     * @param mixed $concluidos
     * @return AgendaUsuarioRelatorio
     */
    public function setConcluidos($concluidos = false)
    {
        if(empty($concluidos) || $concluidos == 'false'){
            $this->concluidos = (bool) false;
            return $this;
        }
        $this->concluidos = $concluidos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     * @return AgendaUsuarioRelatorio
     */
    public function setIdUsuario($idUsuario)
    {
        if(empty($idUsuario) || $idUsuario == 'false' ){
            $this->idUsuario = (bool)false;
            return $this;
        }
        $this->idUsuario = $idUsuario;
        return $this;
    }





}